<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    // Afficher toutes les demandes de congé (Vue Admin)
    public function index()
    {
        // On récupère tous les congés avec les infos de l'employé associé
        $leaves = Leave::with('user')->orderBy('created_at', 'desc')->get();
        return view('leaves.index', compact('leaves'));
    }
    // Approuver un congé
    // Approuver un congé
    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        
        // Calcul du nombre de jours demandés
        $start = \Carbon\Carbon::parse($leave->start_date);
        $end = \Carbon\Carbon::parse($leave->end_date);
        $daysRequested = $start->diffInDays($end) + 1; // +1 pour inclure le jour de début

        // Récupérer l'employé
        $employee = $leave->user;

        // Vérifier s'il a assez de solde
        if ($employee->leave_balance >= $daysRequested) {
            // Déduire le solde
            $employee->leave_balance -= $daysRequested;
            $employee->save();

            // Changer le statut
            $leave->update(['status' => 'approuve']);
            
            return back()->with('success', "Congé approuvé. {$daysRequested} jour(s) déduit(s) du solde de {$employee->name}.");
        } else {
            return back()->with('error', "Impossible d'approuver ! Le solde de {$employee->name} est insuffisant (Il lui reste {$employee->leave_balance} jours).");
        }
    }

    // Refuser un congé
    public function reject($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update(['status' => 'refuse']);
        
        return back()->with('success', 'Congé refusé.');
    }
        // Demander un congé (Côté Employé)
        public function store(Request $request)
        {
            $request->validate([
                'type' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'nullable|string',
            ]);
    
            \App\Models\Leave::create([
                'user_id' => Auth::id(), // Associe au compte connecté
                'type' => $request->type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
                'status' => 'en_attente',
            ]);
    
            return back()->with('success', 'Votre demande de congé a été envoyée avec succès !');
        }
}