<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function create()
    {
        $users = User::all(); // ← Important !
        return view('admin.create-user', compact('users'));
    }

    public function store(Request $request)
    {
        Log::info('REQUÊTE REÇUE', $request->all());

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'role' => 'required|in:admin,residentiel,affaires',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            Log::info('UTILISATEUR CRÉÉ', ['id' => $user->id]);

            return redirect()->route('admin.config')->with('success', 'Utilisateur créé avec succès.');

        } catch (\Exception $e) {
            Log::error('ERREUR CRÉATION USER : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la création de l’utilisateur.');
        }
    }
}
