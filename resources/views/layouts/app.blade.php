<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- LE JETON DE SÉCURITÉ POUR LES MESSAGES -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Gestion RH - Application</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', "resources/js/app.js"])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            body { font-family: 'Inter', sans-serif; }
            .sidebar-link.active { background-color: rgba(255,255,255,0.15); border-left: 4px solid #4ade80; padding-left: 1rem; }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased flex h-screen overflow-hidden">
        
        @auth
            <!-- OVERLAY NOIR POUR MOBILE (Apparaît quand le menu est ouvert) -->
            <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden hidden" onclick="closeSidebar()"></div>

            <!-- SIDEBAR -->
            <!-- md:relative md:translate-x-0 = Toujours visible sur grand écran -->
            <!-- absolute -translate-x-full = Caché à gauche sur mobile par défaut -->
            <aside id="sidebar" class="w-64 bg-green-900 text-white flex flex-col flex-shrink-0 transition-transform duration-300 ease-in-out z-30 absolute inset-y-0 left-0 -translate-x-full md:relative md:translate-x-0">
                
                <div class="h-16 flex items-center justify-between px-4 border-b border-green-800">
                    <h1 class="text-2xl font-bold tracking-wider">Gestion<span class="text-green-400">RH</span></h1>
                    <!-- Bouton Fermer sur Mobile -->
                    <button onclick="closeSidebar()" class="md:hidden text-white hover:text-green-400 focus:outline-none">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <!-- Lien Tableau de Bord (Tout le monde) -->
                    <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie w-6 text-center"></i>
                        <span class="ml-3 font-medium">Tableau de Bord</span>
                    </a>

                    @if(Auth::user()->role === 'admin')
                        <!-- MENU ADMIN SEULEMENT -->
                        <a href="{{ route('employees.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('employees*') ? 'active' : '' }}">
                            <i class="fas fa-users w-6 text-center"></i>
                            <span class="ml-3 font-medium">Employés</span>
                        </a>

                        <a href="{{ route('leaves.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('leaves*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt w-6 text-center"></i>
                            <span class="ml-3 font-medium">Congés</span>
                        </a>

                        <a href="{{ route('payroll.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('payroll*') ? 'active' : '' }}">
                            <i class="fas fa-money-bill-wave w-6 text-center"></i>
                            <span class="ml-3 font-medium">Paie</span>
                        </a>

                        <a href="{{ route('presence.admin') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('presence*') ? 'active' : '' }}">
                            <i class="fas fa-fingerprint w-6 text-center"></i>
                            <span class="ml-3 font-medium">Pointage</span>
                        </a>

                        <a href="{{ route('departments.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('departments*') ? 'active' : '' }}">
                            <i class="fas fa-building w-6 text-center"></i>
                            <span class="ml-3 font-medium">Départements</span>
                        </a>
                        <a href="{{ route('reminders.admin') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('reminders*') ? 'active' : '' }}">
                            <i class="fas fa-bell w-6 text-center"></i>
                            <span class="ml-3 font-medium">Rappels RH</span>
                        </a>
                        <a href="{{ route('settings.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('settings*') ? 'active' : '' }}">
                            <i class="fas fa-cog w-6 text-center"></i>
                            <span class="ml-3 font-medium">Paramètres</span>
                        </a>
                        <a href="{{ route('formations.admin') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('formations.admin*') || request()->routeIs('formations.create') ? 'active' : '' }}">
                            <i class="fas fa-graduation-cap w-6 text-center"></i>
                            <span class="ml-3 font-medium">Formations</span>
                        </a>
                        <a href="{{ route('evaluations.admin') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('evaluations*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar w-6 text-center"></i>
                            <span class="ml-3 font-medium">Évaluations</span>
                        </a>
                        <a href="{{ route('jobs.admin') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('jobs*') ? 'active' : '' }}">
                            <i class="fas fa-user-plus w-6 text-center"></i>
                            <span class="ml-3 font-medium">Recrutement</span>
                        </a>
                    @else
                        <!-- MENU EMPLOYÉ UNIQUEMENT -->
                        <a href="{{ route('employees.show', Auth::id()) }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors">
                            <i class="fas fa-user-circle w-6 text-center"></i>
                            <span class="ml-3 font-medium">Mon Profil</span>
                        </a>

                        <a href="#section-conges" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors">
                            <i class="fas fa-calendar-alt w-6 text-center"></i>
                            <span class="ml-3 font-medium">Mes Congés</span>
                        </a>

                        <a href="{{ route('employee.mypayslip') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors">
                            <i class="fas fa-file-invoice-dollar w-6 text-center"></i>
                            <span class="ml-3 font-medium">Ma Fiche de Paie</span>
                        </a>

                        <a href="{{ route('employees.downloadContrat', Auth::id()) }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors">
                            <i class="fas fa-file-pdf w-6 text-center"></i>
                            <span class="ml-3 font-medium">Mes Documents</span>
                        </a>
                        <a href="{{ route('formations.employee') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors">
                            <i class="fas fa-graduation-cap w-6 text-center"></i>
                            <span class="ml-3 font-medium">Mes Formations</span>
                        </a>
                        <a href="{{ route('evaluations.employee') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors">
                            <i class="fas fa-chart-bar w-6 text-center"></i>
                            <span class="ml-3 font-medium">Mes Évaluations</span>
                        </a>
                        <a href="{{ route('jobs.public') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors">
                            <i class="fas fa-briefcase w-6 text-center"></i>
                            <span class="ml-3 font-medium">Carrières</span>
                        </a>
                    @endif
                </nav>

                <div class="p-4 border-t border-green-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-white rounded-lg hover:bg-red-600 hover:shadow-md transition-all">
                            <i class="fas fa-sign-out-alt w-6 text-center"></i>
                            <span class="ml-3">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- CONTENU PRINCIPAL -->
            <div class="flex-1 flex flex-col overflow-hidden w-0"> <!-- w-0 fixe un bug de flex sur mobile -->
                
                <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 md:px-8 z-10 flex-shrink-0">
                    <!-- Bouton Menu Hamburger (Visible uniquement sur mobile) -->
                    <button onclick="openSidebar()" class="md:hidden text-gray-500 focus:outline-none mr-3">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- TITRE DYNAMIQUE CORRIGÉ -->
                    @php
                        $titre = 'Tableau de Bord';
                        $routeActuelle = request()->route() ? request()->route()->getName() : '';
                        
                        if ($routeActuelle) {
                            // Si on est sur une page Employé (employees.xxx)
                            if (str_contains($routeActuelle, 'employees.')) {
                                if (str_contains($routeActuelle, 'create')) $titre = 'Ajouter un employé';
                                elseif (str_contains($routeActuelle, 'edit')) $titre = 'Modifier un employé';
                                elseif (str_contains($routeActuelle, 'payslip')) $titre = 'Bulletin de paie';
                                elseif (str_contains($routeActuelle, 'show')) $titre = 'Fiche employé';
                                else $titre = 'Liste du personnel';
                            } 
                            // Si on est sur la page Paie (payroll.index)
                            elseif ($routeActuelle === 'payroll.index') {
                                $titre = 'Masse salariale';
                            } 
                            // Si on est sur les congés (leaves.xxx)
                            elseif (str_contains($routeActuelle, 'leaves.')) {
                                $titre = 'Gestion des congés';
                            } 
                            // Si l'employé regarde son bulletin
                            elseif ($routeActuelle === 'employee.mypayslip') {
                                $titre = 'Mon bulletin de paie';
                            }
                            // Ajout pour le Pointage
                            elseif (str_contains($routeActuelle, 'presence')) {
                                $titre = 'Pointage';
                            }
                            elseif (str_contains($routeActuelle, 'department')) {
                                $titre = 'Départements';
                            }
                            elseif (str_contains($routeActuelle, 'setting')) {
                                $titre = 'Paramètres';
                            }
                            elseif (str_contains($routeActuelle, 'jobs')) {
                                $titre = 'Recrutement';
                            }
                            elseif (str_contains($routeActuelle, 'onboarding')) {
                                $titre = 'Intégration du candidat';
                            }
                            elseif (str_contains($routeActuelle, 'candidatures')) {
                                $titre = 'Suivi des candidatures';
                            }
                            elseif (str_contains($routeActuelle, 'evaluations')) {
                                $titre = 'Évaluations';
                            }
                            elseif ($routeActuelle === 'evaluations.employee') {
                                $titre = 'Mes évaluations';
                            }
                            elseif (str_contains($routeActuelle, 'formations')) {
                                $titre = 'Formations';
                            }
                            elseif (str_contains($routeActuelle, 'reminders')) {
                                $titre = 'Bien-être & Rappels';
                            }
                        }
                    @endphp
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 truncate">{{ $titre }}</h2>
                    
                    <!-- CÔTÉ DROIT : Profil + Cloche -->
                    <div class="flex items-center space-x-2 md:space-x-4">
                        
                        <!-- CLOCHE DE NOTIFICATIONS -->
                        <div class="relative">
                            @php
                                // On calcule le vrai nombre de notifications non lues directement ici
                                $dynamicNotifCount = 0;
                                if(Auth::user()->role === 'admin') {
                                    $dynamicNotifCount = \App\Models\Leave::where('status', 'en_attente')->count();
                                } else {
                                    // Pour l'employé, on compte SEULEMENT ses demandes EN ATTENTE
                                    $dynamicNotifCount = \App\Models\Leave::where('user_id', Auth::id())->where('status', 'en_attente')->count();
                                }
                            @endphp

                            <button onclick="document.getElementById('notif-dropdown').classList.toggle('hidden')" class="relative text-gray-400 hover:text-green-600 transition focus:outline-none p-2">
                                <i class="fas fa-bell text-lg"></i>
                                @if($dynamicNotifCount > 0)
                                    <span class="absolute top-0 right-0 h-5 w-5 rounded-full bg-red-500 text-white text-xs flex items-center justify-center font-bold">{{ $dynamicNotifCount }}</span>
                                @endif
                            </button>
                            
                            <!-- Menu déroulant des notifications -->
                            <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 overflow-hidden">
                                <div class="p-3 bg-gray-50 border-b font-semibold text-sm text-gray-700">Notifications</div>
                                
                                @php 
                                    if(Auth::user()->role === 'admin') {
                                        $pendingLeaves = \App\Models\Leave::where('status', 'en_attente')->orderBy('created_at', 'desc')->take(4)->get(); 
                                    } else {
                                        // On affiche les 4 dernières demandes de l'employé
                                        $pendingLeaves = \App\Models\Leave::where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(4)->get(); 
                                    }
                                @endphp
                                
                                <div class="max-h-64 overflow-y-auto">
                                    @forelse($pendingLeaves as $notif)
                                        <a href="{{ route('dashboard') }}" class="flex items-start p-3 hover:bg-gray-50 border-b border-gray-100 text-left">
                                            <div class="bg-yellow-100 text-yellow-600 rounded-full p-2 mr-3 mt-0.5 flex-shrink-0">
                                                <i class="fas fa-clock text-xs"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm text-gray-900 font-medium truncate">
                                                    @if(Auth::user()->role === 'admin')
                                                        {{ $notif->user->name }}
                                                    @else
                                                        Ma demande
                                                    @endif
                                                </p>
                                                <p class="text-xs text-gray-500">Demande de {{ strtolower($notif->type) }} 
                                                    @if($notif->status === 'approuve')
                                                        <span class="text-green-600 font-semibold">approuvée</span>
                                                    @elseif($notif->status === 'refuse')
                                                        <span class="text-red-600 font-semibold">refusée</span>
                                                    @else
                                                        <span class="text-yellow-600 font-semibold">en attente</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="p-6 text-center text-sm text-gray-400">Aucune notification</div>
                                    @endforelse
                                </div>
                                
                                @if(Auth::user()->role === 'admin' && $dynamicNotifCount > 0)
                                    <a href="{{ route('leaves.index') }}" class="block p-3 text-center text-sm font-medium text-green-600 hover:bg-green-50 border-t">
                                        Voir toutes les demandes
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Profil Utilisateur (Menu déroulant pro) -->
                        <div class="relative" id="profile-menu-container">
                            <button onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')" class="flex items-center space-x-2 md:space-x-3 border-l pl-2 md:pl-4 border-gray-200 hover:bg-gray-50 rounded-lg py-1 px-2 transition">
                                <p class="text-sm font-bold text-gray-900 hidden lg:block truncate max-w-[120px]">{{ Auth::user()->name }}</p>
                                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.Auth::user()->name.'&background=16a34a&color=fff' }}" alt="Avatar" class="h-9 w-9 md:h-10 md:w-10 rounded-full border-2 border-green-500 flex-shrink-0">
                                <i class="fas fa-chevron-down text-gray-400 text-xs hidden md:block"></i>
                            </button>
                            
                            <!-- Menu déroulant -->
                            <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50 overflow-hidden">
                                <!-- En-tête du menu -->
                                <div class="p-4 bg-gray-50 border-b">
                                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                </div>
                                
                                <!-- Liens du menu -->
                                <div class="py-2">
                                    <a href="{{ route('employees.show', Auth::id()) }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-user-circle w-5 text-center mr-3 text-gray-400"></i> Mon Profil
                                    </a>
                                    <a href="#" onclick="openPasswordModal(); return false;" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-lock w-5 text-center mr-3 text-gray-400"></i> Sécurité
                                    </a>
                                </div>
                                
                                <!-- Déconnexion -->
                                <div class="border-t border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 font-medium transition">
                                            <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i> Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 md:p-8">
                    
                    <!-- BLOC D'ERREUR GLOBAL (AJOUTÉ ICI) -->
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        @else
            <div class="min-h-screen flex items-center justify-center bg-gray-100 w-full">
                {{ $slot }}
            </div>
        @endauth

        <!-- Script pour contrôler les menus -->
        <script>
            // Fermer les menus déroulants si on clique en dehors
            window.addEventListener('click', function(e) {
                // Fermer le menu Profil
                const profileContainer = document.getElementById('profile-menu-container');
                const profileMenu = document.getElementById('profile-dropdown');
                if (profileContainer && profileMenu && !profileContainer.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }

                // Fermer la cloche de notification
                const notifMenu = document.getElementById('notif-dropdown');
                if (notifMenu && !notifMenu.parentElement.contains(e.target)) {
                    notifMenu.classList.add('hidden');
                }
            });

            function openSidebar() {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('sidebar').classList.add('translate-x-0');
                document.getElementById('sidebar-overlay').classList.remove('hidden');
                document.body.classList.add('overflow-hidden'); 
            }

            function closeSidebar() {
                document.getElementById('sidebar').classList.add('-translate-x-full');
                document.getElementById('sidebar').classList.remove('translate-x-0');
                document.getElementById('sidebar-overlay').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        </script>
        @stack('scripts')

        <!-- POP-UP DE MODIFICATION DU MOT DE PASSE (UNIQUE) -->
        <div id="password-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6 relative">
                <button onclick="closePasswordModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
                
                <h3 class="text-xl font-bold text-gray-900 mb-1">Modifier mon mot de passe</h3>
                <p class="text-sm text-gray-500 mb-6">Assurez-vous de choisir un mot de passe sécurisé (min. 8 caractères).</p>

                <form action="{{ route('employee.changePassword') }}" method="POST">
                    @csrf
                    
                    <!-- AFFICHAGE DES ERREURS -->
                    <div class="mb-4">
                        @if($errors->has('new_password'))
                            <div class="bg-red-50 border-l-4 border-red-500 p-3 text-red-700 text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first('new_password') }}
                            </div>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ancien mot de passe</label>
                            <input type="password" name="current_password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="new_password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="new_password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 text-white py-2.5 px-4 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SCRIPT UNIQUE -->
        <script>
            // Fonctions pour le pop-up de mot de passe
            function openPasswordModal() {
                document.getElementById('password-modal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closePasswordModal() {
                document.getElementById('password-modal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

                        // Rouvrir le pop-up SEULEMENT s'il y a une erreur de mot de passe
                        document.addEventListener("DOMContentLoaded", function() {
            @if($errors->has('new_password'))
                openPasswordModal();
            @endif
        });

            // Fermer les menus déroulants si on clique en dehors
            window.addEventListener('click', function(e) {
                const profileContainer = document.getElementById('profile-menu-container');
                const profileMenu = document.getElementById('profile-dropdown');
                if (profileContainer && profileMenu && !profileContainer.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }

                const notifMenu = document.getElementById('notif-dropdown');
                if (notifMenu && !notifMenu.parentElement.contains(e.target)) {
                    notifMenu.classList.add('hidden');
                }
            });

            function openSidebar() {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('sidebar').classList.add('translate-x-0');
                document.getElementById('sidebar-overlay').classList.remove('hidden');
                document.body.classList.add('overflow-hidden'); 
            }

            function closeSidebar() {
                document.getElementById('sidebar').classList.add('-translate-x-full');
                document.getElementById('sidebar').classList.remove('translate-x-0');
                document.getElementById('sidebar-overlay').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        </script>
    </body>
</html>