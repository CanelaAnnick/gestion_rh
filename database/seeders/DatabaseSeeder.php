<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Leave;
use App\Models\Job;
use App\Models\Candidature;
use App\Models\Evaluation;
use App\Models\Formation;
use App\Models\Reminder;
use App\Models\Message;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Vider les tables pour repartir à zéro
        User::truncate();
        Department::truncate();
        Leave::truncate();
        Job::truncate();
        Candidature::truncate();
        Evaluation::truncate();
        Formation::truncate();
        Reminder::truncate();
        Message::truncate();

        // 2. Créer l'Admin
        User::create([
            'name' => 'Mireille Nkodo',
            'email' => 'admin@gestion-rh.cm', // METS LE VRAI EMAIL ICI
            'password' => Hash::make('admin'), // Le mot de passe demandé
            'role' => 'admin',
            'poste' => 'Directrice RH',
            'departement' => 'Ressources Humaines',
            'salaire' => 500000,
            'leave_balance' => 30,
        ]);

        // 3. Créer les Départements
        Department::insert([
            ['name' => 'Informatique', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Marketing', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 4. Créer les 2 Employés
        $jean = User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@gestion-rh.cm',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'poste' => 'Développeur Full-Stack',
            'departement' => 'Informatique',
            'salaire' => 350000,
            'leave_balance' => 18,
            'contrat_file' => null,
        ]);

        $arie = User::create([
            'name' => 'Arielle Nganou',
            'email' => 'ariele.nganou@gestion-rh.cm',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'poste' => 'Responsable Marketing',
            'departement' => 'Marketing',
            'salaire' => 300000,
            'leave_balance' => 22,
            'contrat_file' => null,
        ]);

        // 5. Créer des Congés
        Leave::create([
            'user_id' => $jean->id,
            'type' => 'Annuel',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(10),
            'reason' => 'Vacances familiales',
            'status' => 'en_attente',
        ]);
        Leave::create([
            'user_id' => $arie->id,
            'type' => 'Maladie',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(8),
            'reason' => 'Grippe',
            'status' => 'approuve',
        ]);

        // 6. Créer des Offres d'emploi
        $job1 = Job::create([
            'title' => 'Chef de Projet Digital',
            'department' => 'Informatique',
            'type' => 'CDI',
            'description' => 'Nous recherchons un chef de projet expérimenté pour gérer nos nouveaux produits web.',
            'requirements' => 'Agile-Scrum-Gestion de budget-Communication',
            'status' => 'ouverte',
            'verified_at' => now(),
        ]);
        Job::create([
            'title' => 'Community Manager',
            'department' => 'Marketing',
            'type' => 'CDD',
            'description' => 'Gestion des réseaux sociaux.',
            'status' => 'pourvue',
            'verified_at' => now()->subDays(15),
        ]);

        // 7. Créer une Candidature pour l'offre ouverte
        Candidature::create([
            'job_id' => $job1->id,
            'first_name' => 'Karl',
            'last_name' => 'Takam',
            'email' => 'karl.takam@gmail.com',
            'phone' => '699999999',
            'cv_path' => 'cvs/fake_cv.pdf', // Fichier fictif
            'status' => 'nouveau',
        ]);

        // 8. Créer une Évaluation pour Jean
        Evaluation::create([
            'user_id' => $jean->id,
            'period' => 'Trimestre 1 2024',
            'objectifs' => 'Livrer la nouvelle application RH, former les utilisateurs.',
            'note' => 4,
            'commentaires' => 'Excellent travail sur le back-end. À améliorer la communication avec le front-end.',
            'status' => 'terminee',
        ]);

        // 9. Créer des Formations
        Formation::create([
            'title' => 'Sécurité des données informatiques',
            'description' => 'Formation obligatoire sur le RGPD.',
            'date_debut' => now()->addDays(15),
            'date_fin' => now()->addDays(16),
            'formateur' => 'Centre AFG',
            'status' => 'planifiee',
        ]);

        // 10. Créer des Rappels
        Reminder::create([
            'title' => 'Anniversaire de Jean',
            'date_event' => now()->addDays(12),
            'type' => 'anniversaire',
            'is_read' => false,
        ]);
        Reminder::create([
            'title' => 'Fin de période d\'essai Arielle',
            'date_event' => now()->subDays(2),
            'type' => 'contrat',
            'is_read' => false,
        ]);

        // 11. Créer un Message de l'admin à Jean
        Message::create([
            'user_id' => $jean->id,
            'subject' => 'Rappel documents manquants',
            'content' => 'Bonjour Jean, merci de nous fournir votre RIB et votre certificat de travail précédent au service RH.',
            'is_read' => false,
        ]);
    }
}