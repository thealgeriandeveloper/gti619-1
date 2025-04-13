<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(): void
    {
        // Clients résidentiels
        Client::create([
            'nom' => 'Jean Tremblay',
            'email' => 'jean.resident@example.com',
            'type' => 'residentiel',
        ]);

        Client::create([
            'nom' => 'Sophie Gagnon',
            'email' => 'sophie.resident@example.com',
            'type' => 'residentiel',
        ]);

        Client::create([
            'nom' => 'David Martel',
            'email' => 'david.martel@example.com',
            'type' => 'residentiel',
        ]);

        // Clients d'affaires
        Client::create([
            'nom' => 'Entreprise ABC Inc.',
            'email' => 'contact@abcinc.com',
            'type' => 'affaires',
        ]);

        Client::create([
            'nom' => 'Solutions XYZ',
            'email' => 'info@xyzsolutions.ca',
            'type' => 'affaires',
        ]);

        Client::create([
            'nom' => 'BureauTech',
            'email' => 'service@bureautech.com',
            'type' => 'affaires',
        ]);
    }

}
