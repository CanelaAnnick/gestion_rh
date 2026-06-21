<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // Page publique (Candidats)
    public function publicIndex()
    {
        $jobs = Job::where('status', 'ouverte')->orderBy('created_at', 'desc')->get();
        return view('jobs.public-index', compact('jobs'));
    }

    // Page Admin
    public function adminIndex()
    {
        $jobs = Job::orderBy('verified_at', 'desc')->get();
        return view('jobs.admin-index', compact('jobs')); 
    }

    // Publier une offre
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string',
            'type' => 'required|in:CDI,CDD,Stage',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);

        Job::create([
            'title' => $request->title,
            'department' => $request->department,
            'type' => $request->type,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'status' => 'ouverte',
            'verified_at' => now()   
        ]);

        return back()->with('success', 'Offre publiée avec succès !');
    }

    // NOUVEAU : Changer le statut d'une offre
    public function updateStatus(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $request->validate([
            'status' => 'required|in:ouverte,fermee,pourvue'
        ]);

        $job->update(['status' => $request->status]);

        return back()->with('success', 'Le statut de l\'offre a été mis à jour.');
    }

    // Supprimer
    public function destroy($id)
    {
        Job::findOrFail($id)->delete();
        return back()->with('success', 'Offre supprimée.');
    }
}