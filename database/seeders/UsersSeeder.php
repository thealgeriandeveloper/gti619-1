<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin123!'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Utilisateur1',
            'email' => 'residence@example.com',
            'password' => Hash::make('Resident123!'),
            'role' => 'residentiel',
        ]);

        User::create([
            'name' => 'Utilisateur2',
            'email' => 'affaires@example.com',
            'password' => Hash::make('Affaires123!'),
            'role' => 'affaires',
        ]);
    }
}
