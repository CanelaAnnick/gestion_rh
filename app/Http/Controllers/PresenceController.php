<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PresenceController extends Controller
{
    // L'employé pointe son arrivée
    public function checkIn(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $presence = Presence::where('user_id', Auth::id())->where('date', $today)->first();

        if ($presence && $presence->heure_arrivee) {
            return back()->with('error', 'Vous avez déjà pointé votre arrivée aujourd\'hui.');
        }

        $data = [
            'heure_arrivee' => Carbon::now()->toTimeString(), 
            'statut' => 'present'
        ];

        // On ajoute les coordonnées GPS si le navigateur les a envoyées
        if ($request->filled('latitude') && $request->filled('longitude')) {
            $data['latitude'] = $request->latitude;
            $data['longitude'] = $request->longitude;
        }

        Presence::updateOrCreate(
            ['user_id' => Auth::id(), 'date' => $today],
            $data
        );

        return back()->with('success', 'Arrivée pointée à ' . Carbon::now()->format('H:i') . ' !');
    }

    public function checkOut(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $presence = Presence::where('user_id', Auth::id())->where('date', $today)->first();

        if (!$presence || !$presence->heure_arrivee) {
            return back()->with('error', 'Vous devez pointer votre arrivée d\'abord !');
        }

        if ($presence->heure_depart) {
            return back()->with('error', 'Vous avez déjà pointé votre départ.');
        }

        $data = ['heure_depart' => Carbon::now()->toTimeString()];

        if ($request->filled('latitude') && $request->filled('longitude')) {
            $data['latitude'] = $request->latitude;
            $data['longitude'] = $request->longitude;
        }

        $presence->update($data);

        return back()->with('success', 'Départ pointé à ' . Carbon::now()->format('H:i') . ' ! Bonne soirée.');
    }

    // L'admin voit le pointage du jour
    // L'admin voit le pointage du jour
    public function adminIndex()
    {
        // SÉCURITÉ : Si ce n'est pas un admin, on jette une erreur 403
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }

        $today = Carbon::today()->toDateString();
        
        // On récupère tous les employés, et on joint leur pointage d'aujourd'hui s'il existe
        $employees = \App\Models\User::where('role', 'employee')
            ->leftJoin('presences', function($join) use ($today) {
                $join->on('users.id', '=', 'presences.user_id')
                     ->where('presences.date', '=', $today);
            })
            ->select('users.*', 'presences.heure_arrivee', 'presences.heure_depart', 'presences.statut', 'presences.latitude', 'presences.longitude')
            ->get();

        return view('presences.index', compact('employees', 'today'));
    }
}