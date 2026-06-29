<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    // Page Admin : Liste des rappels à venir et passés
    public function adminIndex()
    {
        // On récupère les rappels des 30 prochains jours (non traités) et les passés (traités ou non)
        $upcomingReminders = Reminder::where('date_event', '>=', now())
                                     ->where('is_read', false)
                                     ->orderBy('date_event', 'asc')
                                     ->get();

        $pastReminders = Reminder::where('date_event', '<', now())
                                 ->orderBy('date_event', 'desc')
                                 ->get();

        return view('reminders.admin-index', compact('upcomingReminders', 'pastReminders'));
    }

    // Ajouter un rappel
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date_event' => 'required|date',
            'type' => 'required|in:anniversaire,contrat,evenement',
        ]);

        Reminder::create($request->all());

        return back()->with('success', 'Rappel ajouté avec succès !');
    }

    // Marquer comme traité (ou annuler le traitement)
    public function toggleRead($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->update(['is_read' => !$reminder->is_read]);
        
        return back()->with('success', 'Statut du rappel mis à jour.');
    }

    // Supprimer un rappel
    public function destroy($id)
    {
        Reminder::findOrFail($id)->delete();
        return back()->with('success', 'Rappel supprimé.');
    }
}