<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\SecurityLog;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function username()
    {
        return 'email';
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            event(new Lockout($request));
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);
            throw ValidationException::withMessages([
                'email' => "Trop de tentatives. Réessayez dans {$minutes} minute(s)."
            ])->status(429);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            SecurityLog::create([
                'user_id' => Auth::id(),
                'event' => 'login',
                'details' => 'Connexion réussie',
                'ip' => $request->ip(),
            ]);
            RateLimiter::clear($throttleKey);
            // Régénérer l'identifiant de session pour éviter la fixation de session
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        RateLimiter::hit($throttleKey, 60); // Blocage pendant 60 sec après échec
        return back()->withErrors([
            'email' => 'Les informations d’identification sont invalides.',
        ]);
    }

    public function logout(Request $request)
    {
        // Capture l'ID utilisateur avant de le déconnecter
        $userId = Auth::id();

        // Journalise la déconnexion
        SecurityLog::create([
            'user_id' => $userId,
            'event' => 'logout',
            'details' => 'Déconnexion',
            'ip' => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
