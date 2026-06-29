<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    // Page Admin : Liste de toutes les évaluations
    public function adminIndex()
    {
        $evaluations = Evaluation::with('user')->orderBy('created_at', 'desc')->get();
        return view('evaluations.admin-index', compact('evaluations'));
    }

    // Formulaire pour créer une nouvelle évaluation
    public function create()
    {
        // On ne peut évaluer que les employés (pas les admins)
        $employees = User::where('role', 'employee')->get();
        return view('evaluations.create', compact('employees'));
    }

    // Enregistrer les objectifs
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'period' => 'required|string|max:255',
            'objectifs' => 'required|string',
        ]);

        Evaluation::create([
            'user_id' => $request->user_id,
            'period' => $request->period,
            'objectifs' => $request->objectifs,
            'status' => 'en_attente'
        ]);

        return redirect()->route('evaluations.admin')->with('success', 'Évaluation créée avec succès. En attente de notation.');
    }

    // Formulaire pour mettre la note (étoiles)
    public function edit(Evaluation $evaluation)
    {
        return view('evaluations.edit', compact('evaluation'));
    }

    // Sauvegarder la note et terminer l'évaluation
    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaires' => 'nullable|string',
        ]);

        $evaluation->update([
            'note' => $request->note,
            'commentaires' => $request->commentaires,
            'status' => 'terminee'
        ]);

        return redirect()->route('evaluations.admin')->with('success', 'Évaluation terminée et notifiée à l\'employé.');
    }
        // Page Employé : Voir ses propres évaluations
        public function employeeIndex()
        {
            // On ne récupère QUE les évaluations de l'employé connecté
            $evaluations = Evaluation::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
            return view('evaluations.employee-index', compact('evaluations'));
        }
}