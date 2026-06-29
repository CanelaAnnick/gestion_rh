<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Job;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    // Formulaire public (soumission)
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048', // 2MB max, PDF ou Word
        ]);

        // Sauvegarde du fichier CV dans storage/app/public/cvs
        $cvPath = $request->file('cv')->store('cvs', 'public');

        // Création de la candidature en base de données
        Candidature::create([
            'job_id' => $jobId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cv_path' => $cvPath,
        ]);

        return back()->with('success', 'Votre candidature a été envoyée avec succès !');
    }

    // Page Admin pour voir les candidatures d'une offre
    public function index($jobId)
    {
        $job = Job::findOrFail($jobId);
        $candidatures = Candidature::where('job_id', $jobId)->orderBy('created_at', 'desc')->get();
        
        return view('jobs.admin-candidatures', compact('job', 'candidatures'));
    }

    // Télécharger un CV depuis l'admin
    public function downloadCv($id)
    {
        $candidature = Candidature::findOrFail($id);
        $path = storage_path('app/public/' . $candidature->cv_path);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->download($path);
    }
        // Mettre à jour le statut et les notes d'un candidat
        public function update(Request $request, $id)
        {
            $candidature = Candidature::findOrFail($id);
            
            $request->validate([
                'status' => 'required|in:nouveau,entretien,retenu,refuse',
                'notes' => 'nullable|string'
            ]);
    
            $candidature->update([
                'status' => $request->status,
                'notes' => $request->notes
            ]);
    
            return back()->with('success', 'Candidature mise à jour avec succès.');
        }
            // Afficher la page d'intégration (Checklist)
    // Afficher la page d'intégration (Checklist)
    public function onboardingIndex($id)
    {
        $candidature = Candidature::findOrFail($id);
        
        $defaultTasks = [
            'Contrat de travail signé' => false,
            'Pièce d\'identité (CNI/Passport) fournie' => false,
            'RIB (Relevé d\'identité bancaire) fourni' => false,
            'Attestation de domicile fournie' => false,
            'Certificat de travail précédent fourni' => false,
            'Matériel informatique attribué' => false,
            'Accès aux logiciels configurés' => false,
            'Visite médicale effectuée' => false,
        ];

        // NOUVEAU : Si la base est vide, on sauvegarde les tâches par défaut DANS la base immédiatement !
        if (is_null($candidature->onboarding_data)) {
            $candidature->update(['onboarding_data' => $defaultTasks]);
            $tasks = $defaultTasks;
        } else {
            $tasks = $candidature->onboarding_data;
        }

        return view('jobs.admin-onboarding', compact('candidature', 'tasks'));
    }

    // Mettre à jour une case de la checklist
    public function onboardingUpdate(Request $request, $id)
    {
        $candidature = Candidature::findOrFail($id);
        $tasks = $candidature->onboarding_data ?? [];

        // On inverse l'état de la case cochée (coché -> décoché, décoché -> coché)
        $taskName = $request->task_name;
        if (isset($tasks[$taskName])) {
            $tasks[$taskName] = !$tasks[$taskName];
        }

        $candidature->update(['onboarding_data' => $tasks]);

        return response()->json(['success' => true]);
    }
}