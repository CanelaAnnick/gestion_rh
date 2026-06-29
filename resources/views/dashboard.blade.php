<x-app-layout>
    
    <!-- Grille des Statistiques DYNAMIQUES -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Employés Actifs</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalEmployees }}</h3>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Congés en Attente</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingLeaves }}</h3>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                <i class="fas fa-hourglass-half text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Masse Salariale</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalSalary, 0, ',', ' ') }} <span class="text-sm text-gray-500 font-normal">FCFA</span></h3>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-coins text-xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Colonne de gauche : Graphique (On le garde fixe pour l'instant) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <!-- Répartition par département -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Répartition par département</h3>
                
                @forelse($departmentDistribution as $dept)
                    <div class="mb-5 last:mb-0">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-700">{{ $dept->departement }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $dept->total }} employé(s)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="h-3 rounded-full bg-emerald-500 transition-all duration-500" style="width: {{ ($dept->total / $totalEmployees) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-building text-3xl mb-3 block"></i>
                        <p class="text-sm">Aucune donnée disponible.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Colonne de droite : CONGÉS EN ATTENTE DYNAMIQUES -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Congés en Attente</h3>
            </div>

            <div class="space-y-4">
                @forelse($pendingLeaveRequests as $leave)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name={{ $leave->user->name }}&background=f59e0b&color=fff" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $leave->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $leave->type }} ({{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }})</p>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <!-- BOUTON APPROUVER FONCTIONNEL -->
                            <form action="{{ route('leaves.approve', $leave->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:bg-green-100 p-1.5 rounded" title="Approuver">
                                    <i class="fas fa-check text-sm"></i>
                                </button>
                            </form>
                            <!-- BOUTON REFUSER FONCTIONNEL -->
                            <form action="{{ route('leaves.reject', $leave->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:bg-red-100 p-1.5 rounded" title="Refuser">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">Aucune demande en attente.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Derniers Employés (Rappel rapide) -->
    <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Derniers Employés</h3>
            <a href="{{ route('employees.index') }}" class="text-green-600 text-sm font-medium hover:underline">Voir tout</a>
        </div>
        <div class="p-6">
            <p class="text-gray-500 text-sm">Accédez à la liste complète depuis le menu "Employés".</p>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif

</x-app-layout>