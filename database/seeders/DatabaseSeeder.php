<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
    
        // Ajout d'employés fictifs pour le tableau de bord
        \App\Models\User::create([
            'name' => 'Roland Mballa',
            'email' => 'roland@gestion-rh.cm',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'poste' => 'Développeur Fullstack',
            'departement' => 'IT',
            'salaire' => 450000,
        ]);
    
        \App\Models\User::create([
            'name' => 'Arlette Mbarga',
            'email' => 'arlette@gestion-rh.cm',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'poste' => 'Comptable Principal',
            'departement' => 'Finance',
            'salaire' => 300000,
        ]);
    }
}
