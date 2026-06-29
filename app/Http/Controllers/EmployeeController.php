<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::orderBy('created_at', 'desc')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        // On va chercher tous les départements créés dans la base de données
        $departments = \App\Models\Department::orderBy('name', 'asc')->get();
        return view('employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'poste' => 'required|string',
            'departement' => 'required|string',
            'salaire' => 'required|integer',
            'role' => 'required|in:admin,employee',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'poste' => $request->poste,
            'departement' => $request->departement,
            'salaire' => $request->salaire,
            'role' => $request->role,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employé ajouté avec succès !');
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        // On va chercher les départements pour les afficher dans la liste
        $departments = \App\Models\Department::orderBy('name', 'asc')->get();
        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'poste' => 'required|string',
            'departement' => 'required|string',
            'salaire' => 'required|integer',
            'role' => 'required|in:admin,employee',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->poste = $request->poste;
        $employee->departement = $request->departement;
        $employee->salaire = $request->salaire;
        $employee->role = $request->role;

        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employé modifié avec succès !');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employé supprimé.');
    }
        /**
     * Afficher le profil détaillé d'un employé
     */
    public function show($id)
    {
        $employee = User::findOrFail($id);
        
        // Historique des congés
        $leaves = \App\Models\Leave::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        
        // AJOUT : Historique des messages envoyés à cet employé
        $messages = \App\Models\Message::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        
        return view('employees.show', compact('employee', 'leaves', 'messages'));
    }
        /**
     * Uploader un contrat pour un employé
     */
    public function uploadContract(Request $request, $id)
    {
        $request->validate([
            'contrat' => 'required|file|mimes:pdf|max:2048', // Seulement des PDF, max 2Mo
        ]);

        $employee = User::findOrFail($id);
        
        // Stocker le fichier dans storage/app/public/contrats
        if ($request->hasFile('contrat')) {
            $file = $request->file('contrat');
            $fileName = time() . '_' . $employee->name . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/contrats', $fileName);
            
            // Mettre à jour le chemin dans la base de données
            $employee->contrat_file = $fileName;
            $employee->save();
        }

        return back()->with('success', 'Contrat uploadé avec succès !');
    }
        /**
     * Télécharger le contrat d'un employé
     */
    public function downloadContract($id)
    {
        $employee = User::findOrFail($id);
        
        if (!$employee->contrat_file) {
            return back()->with('error', 'Aucun contrat disponible pour le moment.');
        }

        $path = 'public/contrats/' . $employee->contrat_file;

        if (!Storage::exists($path)) {
            abort(404, 'Le fichier n\'existe pas sur le serveur.');
        }

        // Force le téléchargement du fichier
        return Storage::download($path, 'Contrat_' . $employee->name . '.pdf');
    }
        /**
     * Générer le bulletin de paie d'un employé
     */
    public function payslip($id)
    {
        $employee = User::findOrFail($id);
        $salaireBrut = $employee->salaire;
        
        // On va chercher les taux dans la base de données (table settings)
        $cnpsRate = floatval(\App\Models\Setting::where('key', 'cnps_rate')->first()->value ?? 2.8) / 100;
        $taxRate = floatval(\App\Models\Setting::where('key', 'tax_rate')->first()->value ?? 10) / 100;

        $cnps = $salaireBrut * $cnpsRate;
        $impot = $salaireBrut * $taxRate;
        $totalDeductions = $cnps + $impot;
        $salaireNet = $salaireBrut - $totalDeductions;
        $moisAnnee = now()->locale('fr')->translatedFormat('F Y');

        // On passe le nom de l'entreprise au bulletin
        $companyName = \App\Models\Setting::where('key', 'company_name')->first()->value ?? 'Mon Entreprise';

        return view('employees.payslip', compact('employee', 'salaireBrut', 'cnps', 'impot', 'totalDeductions', 'salaireNet', 'moisAnnee', 'companyName', 'cnpsRate', 'taxRate'));
    }
        // Page d'index de la Paie
        public function payrollIndex()
        {
            $employees = User::where('role', 'employee')->get();
            $totalMasseSalariale = $employees->sum('salaire');
            return view('employees.payroll', compact('employees', 'totalMasseSalariale'));
        }
            /**
     * Générer le bulletin de paie de l'employé connecté (Coté Employé)
     */
    /**
     * Générer le bulletin de paie de l'employé connecté (Coté Employé)
     */
    public function myPayslip()
    {
        // On force à prendre l'utilisateur connecté, impossible de tricher
        $employee = Auth::user();
        
        $salaireBrut = $employee->salaire;
        
        // On va chercher les taux dans la base de données (comme pour l'admin)
        $cnpsRate = floatval(\App\Models\Setting::where('key', 'cnps_rate')->first()->value ?? 2.8) / 100;
        $taxRate = floatval(\App\Models\Setting::where('key', 'tax_rate')->first()->value ?? 10) / 100;

        $cnps = $salaireBrut * $cnpsRate;
        $impot = $salaireBrut * $taxRate;
        $totalDeductions = $cnps + $impot;
        $salaireNet = $salaireBrut - $totalDeductions;
        $moisAnnee = now()->locale('fr')->translatedFormat('F Y');
        
        // On récupère aussi le nom de l'entreprise
        $companyName = \App\Models\Setting::where('key', 'company_name')->first()->value ?? 'Mon Entreprise';

        // On réutilise la même vue que l'admin !
        return view('employees.payslip', compact('employee', 'salaireBrut', 'cnps', 'impot', 'totalDeductions', 'salaireNet', 'moisAnnee', 'companyName', 'cnpsRate', 'taxRate'));
    }
        /**
     * Permettre à l'employé connecté de modifier son mot de passe
     */
    /**
     * Permettre à l'utilisateur connecté de modifier son mot de passe
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // 1. Vérifier que l'ancien mot de passe est correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'L\'ancien mot de passe est incorrect.');
        }

        // 2. Forcer la modification dans la base de données
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 3. Rediriger avec le message de succès
        return redirect()->route('dashboard')->with('success', 'Mot de passe modifié avec succès !');
    }
}