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
}