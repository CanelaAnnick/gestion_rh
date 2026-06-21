<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestion RH - Application</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', "resources/js/app.js"])
        
        <!-- FontAwesome pour les icônes -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            body { font-family: 'Inter', sans-serif; }
            /* Style pour le menu actif */
            .sidebar-link.active { background-color: rgba(255,255,255,0.15); border-left: 4px solid #4ade80; padding-left: 1rem; }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased flex h-screen overflow-hidden">
        
        @auth
            <!-- SIDEBAR (Barre Latérale Verte) -->
            <aside class="w-64 bg-green-900 text-white flex flex-col flex-shrink-0 transition-all duration-300 z-20" id="sidebar">
                <!-- Logo -->
                <div class="h-16 flex items-center justify-center border-b border-green-800">
                    <h1 class="text-2xl font-bold tracking-wider">Gestion<span class="text-green-400">RH</span></h1>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <!-- Lien Dashboard -->
                    <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie w-6 text-center"></i>
                        <span class="ml-3 font-medium">Tableau de Bord</span>
                    </a>

                    <!-- Lien Employés -->
                    <a href="{{ route('employees.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors {{ request()->routeIs('employees*') ? 'active' : '' }}">
                        <i class="fas fa-users w-6 text-center"></i>
                        <span class="ml-3 font-medium">Employés</span>
                    </a>

                    <!-- Lien Congés -->
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors">
                        <i class="fas fa-calendar-alt w-6 text-center"></i>
                        <span class="ml-3 font-medium">Congés</span>
                    </a>

                    <!-- Lien Paie -->
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg hover:bg-green-800 transition-colors">
                        <i class="fas fa-money-bill-wave w-6 text-center"></i>
                        <span class="ml-3 font-medium">Paie</span>
                    </a>
                </nav>

                <!-- Déconnexion -->
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
            <div class="flex-1 flex flex-col overflow-hidden">
                
                <!-- Header Supérieur -->
                <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 z-10">
                    <!-- Mobile Toggle -->
                    <button id="mobile-menu-btn" class="md:hidden text-gray-500 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Titre -->
                    <h2 class="text-xl font-semibold text-gray-800">{{ $header ?? 'Tableau de Bord' }}</h2>

                    <!-- Profil Utilisateur -->
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <i class="fas fa-bell text-gray-400 text-lg cursor-pointer hover:text-green-600 transition"></i>
                            <span class="absolute -top-1 -right-1 h-2 w-2 rounded-full bg-red-500"></span>
                        </div>
                        <div class="flex items-center space-x-3 border-l pl-4 border-gray-200">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">{{ Auth::user()->poste ?? 'Employé' }}</p>
                            </div>
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.Auth::user()->name.'&background=16a34a&color=fff' }}" alt="Avatar" class="h-10 w-10 rounded-full border-2 border-green-500">
                        </div>
                    </div>
                </header>

                <!-- Zone de contenu défilable -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 md:p-8">
                    {{ $slot }}
                </main>
            </div>
        @else
            <!-- Si pas connecté (Login page) -->
            <div class="min-h-screen flex items-center justify-center bg-gray-100">
                {{ $slot }}
            </div>
        @endauth

        <!-- Script pour le menu mobile -->
        <script>
            const btn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');
            if(btn && sidebar) {
                btn.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebar.classList.toggle('absolute');
                    sidebar.classList.toggle('h-full');
                    if(sidebar.classList.contains('absolute')) {
                        sidebar.style.zIndex = "50";
                    }
                });
            }
        </script>
    </body>
</html>