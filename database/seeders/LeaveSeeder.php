<?php

namespace Database\Seeders;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
{
    public function run(): void
    {
        // Récupère les employés (pas l'admin)
        $employees = User::where('role', 'employee')->get();

        foreach ($employees as $emp) {
            Leave::create([
                'user_id' => $emp->id,
                'type' => 'Congé Annuel',
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(10),
                'status' => 'en_attente',
                'reason' => 'Voyage familial à Douala'
            ]);
        }
    }
}