<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CandidatureController; // NOUVEAU
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ReminderController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Page publique Carrières
Route::get('/carrieres', [JobController::class, 'publicIndex'])->name('jobs.public');
// NOUVEAU : Route pour soumettre le formulaire de candidature
Route::post('/carrieres/{job}/postuler', [CandidatureController::class, 'store'])->name('candidatures.store');

// Espace Employé
Route::get('/mon-bulletin', [EmployeeController::class, 'myPayslip'])->middleware(['auth'])->name('employee.mypayslip');
Route::get('/mes-evaluations', [EvaluationController::class, 'employeeIndex'])->middleware(['auth'])->name('evaluations.employee');
Route::get('/mes-formations', [FormationController::class, 'employeeIndex'])->middleware(['auth'])->name('formations.employee');

// Dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        $totalEmployees = \App\Models\User::where('role', 'employee')->count();
        $pendingLeaves = \App\Models\Leave::where('status', 'en_attente')->count();
        $totalSalary = \App\Models\User::where('role', 'employee')->sum('salaire');
        $pendingLeaveRequests = \App\Models\Leave::where('status', 'en_attente')->orderBy('created_at', 'desc')->take(5)->get();
        return view('dashboard', compact('totalEmployees', 'pendingLeaves', 'totalSalary', 'pendingLeaveRequests'));
    } else {
        $myLeaves = \App\Models\Leave::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('dashboard-employee', compact('myLeaves'));
    }
})->middleware(['auth'])->name('dashboard');

Route::resource('employees', EmployeeController::class)->middleware(['auth']);
Route::post('/employees/{id}/upload-contrat', [EmployeeController::class, 'uploadContract'])->name('employees.uploadContrat');
Route::get('/employees/{id}/download-contrat', [EmployeeController::class, 'downloadContract'])->name('employees.downloadContrat');
Route::get('/employees/{id}/payslip', [EmployeeController::class, 'payslip'])->name('employees.payslip');

// Routes Protégées (Admin)
Route::middleware(['auth'])->group(function () {
    Route::post('/leaves/{id}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('/leaves/{id}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::post('/employees/{id}/send-message', [MessageController::class, 'send'])->name('messages.send');
    Route::post('/messages/{id}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::get('/parametres', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/parametres', [SettingController::class, 'update'])->name('settings.update');
    
    // Recrutement
    Route::get('/admin/recrutement', [JobController::class, 'adminIndex'])->name('jobs.admin');
    Route::post('/admin/recrutement', [JobController::class, 'store'])->name('jobs.store');
    Route::patch('/admin/recrutement/{id}/status', [JobController::class, 'updateStatus'])->name('jobs.updateStatus');
    Route::delete('/admin/recrutement/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');

    // Évaluations
    Route::get('/admin/evaluations', [EvaluationController::class, 'adminIndex'])->name('evaluations.admin');
    Route::get('/admin/evaluations/create', [EvaluationController::class, 'create'])->name('evaluations.create');
    Route::post('/admin/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/admin/evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('evaluations.edit');
    Route::patch('/admin/evaluations/{evaluation}', [EvaluationController::class, 'update'])->name('evaluations.update');

    // Formations
    Route::get('/admin/formations', [FormationController::class, 'adminIndex'])->name('formations.admin');
    Route::get('/admin/formations/create', [FormationController::class, 'create'])->name('formations.create');
    Route::post('/admin/formations', [FormationController::class, 'store'])->name('formations.store');
    Route::patch('/admin/formations/{id}/status', [FormationController::class, 'updateStatus'])->name('formations.updateStatus');
    
    // NOUVEAU : Voir les candidatures d'une offre + Télécharger CV
    Route::get('/admin/recrutement/{job}/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
    Route::patch('/admin/candidatures/{id}', [CandidatureController::class, 'update'])->name('candidatures.update');
    Route::get('/candidatures/{id}/download-cv', [CandidatureController::class, 'downloadCv'])->name('candidatures.downloadCv');
    // NOUVEAU : Onboarding
    Route::get('/admin/candidatures/{id}/onboarding', [CandidatureController::class, 'onboardingIndex'])->name('candidatures.onboarding');
    Route::patch('/admin/candidatures/{id}/onboarding-update', [CandidatureController::class, 'onboardingUpdate'])->name('candidatures.onboardingUpdate');

    // Bien-être & Rappels
    Route::get('/admin/rappels', [ReminderController::class, 'adminIndex'])->name('reminders.admin');
    Route::post('/admin/rappels', [ReminderController::class, 'store'])->name('reminders.store');
    Route::patch('/admin/rappels/{id}/toggle', [ReminderController::class, 'toggleRead'])->name('reminders.toggle');
    Route::delete('/admin/rappels/{id}', [ReminderController::class, 'destroy'])->name('reminders.destroy');
});

Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
Route::get('/payroll', [EmployeeController::class, 'payrollIndex'])->name('payroll.index');
require __DIR__.'/auth.php';

Route::post('/check-in', [PresenceController::class, 'checkIn'])->name('presence.checkin');
Route::post('/check-out', [PresenceController::class, 'checkOut'])->name('presence.checkout');
Route::get('/admin/pointage', [PresenceController::class, 'adminIndex'])->name('presence.admin');
Route::resource('departments', DepartmentController::class);