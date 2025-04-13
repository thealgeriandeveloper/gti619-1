<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordHistory;
use App\Models\SecurityLog;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('auth.change-password');
    }

    public function change(Request $request)
    {
        $user = Auth::user();

        // Validation du formulaire
        $request->validate([
            'password_actuel' => ['required'],
            'new_password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',       // au moins une minuscule
                'regex:/[A-Z]/',       // au moins une majuscule
                'regex:/[0-9]/',       // au moins un chiffre
                'regex:/[@$!%*?&]/',    // au moins un caractère spécial
                'confirmed'
            ],
        ]);

        // Vérifier que le mot de passe actuel est correct
        if (!Hash::check($request->password_actuel, $user->password)) {
            return back()->withErrors(['password_actuel' => 'Mot de passe actuel incorrect.']);
        }

        // Empêcher d'utiliser le même mot de passe que celui en cours
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Vous ne pouvez pas utiliser le même mot de passe que votre mot de passe actuel.']);
        }

        // Récupérer les 3 derniers anciens mots de passe
        $oldPasswords = PasswordHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Log pour debugger
        \Log::info("Old passwords for user {$user->id}:", $oldPasswords->toArray());

        // Vérifier que le nouveau mdp n'a pas été utilisé récemment
        foreach ($oldPasswords as $old) {
            if (Hash::check($request->new_password, $old->password)) {
                return back()->withErrors(['new_password' => 'Vous ne pouvez pas réutiliser un ancien mot de passe.']);
            }
        }

        // Sauvegarder l'ancien mot de passe AVANT de le modifier
        $ancienMotDePasseHashé = $user->password;
        PasswordHistory::create([
            'user_id' => $user->id,
            'password' => $ancienMotDePasseHashé,
        ]);

        // Mettre à jour le nouveau mot de passe
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Conserver seulement les 3 derniers anciens mots de passe
        PasswordHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->skip(3)
            ->delete();

        // Journaliser l'événement dans la table security_logs
        SecurityLog::create([
            'user_id' => $user->id,
            'event' => 'password_change',
            'details' => 'Mot de passe modifié',
            'ip' => $request->ip(),
        ]);

        return redirect()->route('home')->with('success', 'Mot de passe modifié avec succès.');
    }
}
