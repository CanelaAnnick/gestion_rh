<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    // Page Admin
    public function adminIndex()
    {
        $formations = Formation::orderBy('date_debut', 'desc')->get();
        return view('formations.admin-index', compact('formations'));
    }

    // Formulaire de création
    public function create()
    {
        return view('formations.create');
    }

    // Enregistrer
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'formateur' => 'nullable|string|max:255',
        ]);

        Formation::create($request->all());

        return redirect()->route('formations.admin')->with('success', 'Formation planifiée avec succès !');
    }

    // Changer le statut
    public function updateStatus(Request $request, $id)
    {
        $formation = Formation::findOrFail($id);
        $request->validate(['status' => 'required|in:planifiee,en_cours,terminee']);
        $formation->update(['status' => $request->status]);
        return back()->with('success', 'Statut de la formation mis à jour.');
    }

    // Page Employé (Voir les formations à venir)
    // Page Employé (Voir ses formations à venir et passées)
    public function employeeIndex()
    {
        // On récupère TOUTES les formations, mais on met les plus récentes en premier
        $formations = Formation::orderBy('date_debut', 'desc')->get();
        return view('formations.employee-index', compact('formations'));
    }
}