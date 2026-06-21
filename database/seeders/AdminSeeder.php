<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Mireille Nkodo',
            'email' => 'admin@gestion-rh.cm',
            'password' => Hash::make('password'), // Mot de passe : password
            'role' => 'admin',
            'poste' => 'Directrice des Ressources Humaines',
            'departement' => 'RH',
            'salaire' => 850000, // 850.000 FCFA
        ]);
    }
}