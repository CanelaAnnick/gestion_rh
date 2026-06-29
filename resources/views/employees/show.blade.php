<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Lien retour -->
        <a href="{{ route('employees.index') }}" class="inline-flex items-center text-sm text-green-600 hover:text-green-500 mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
        </a>

        <!-- En-tête du profil -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
            <div class="h-32 bg-green-700 relative"></div>
            <div class="px-8 pb-8 relative">
                <img class="h-24 w-24 rounded-full border-4 border-white bg-gray-300 absolute -top-12 shadow-lg" 
                     src="https://ui-avatars.com/api/?name={{ $employee->name }}&background=16a34a&color=fff&size=128" alt="">
                
                <div class="pt-4 flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $employee->name }}</h2>
                        <p class="text-gray-500 mt-1">{{ $employee->poste }} — {{ $employee->departement }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('employees.edit', $employee->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-pen mr-2"></i> Modifier
                        </a>
                        <!-- NOUVEAU BOUTON -->
                        <a href="{{ route('employees.payslip', $employee->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            <i class="fas fa-file-invoice-dollar mr-2"></i> Voir Bulletin
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne de gauche : Informations -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Infos personnelles -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Informations Personnelles</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $employee->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Rôle Système</p>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($employee->role) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date d'embauche</p>
                            <p class="text-sm font-medium text-gray-900">{{ $employee->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Infos financières -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Paie</h3>
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-gray-500">Solde de congés</p>
                        <p class="text-lg font-bold text-yellow-600">{{ $employee->leave_balance }} <span class="text-xs text-gray-500 font-normal">jours</span></p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">Salaire de base</p>
                        <p class="text-lg font-bold text-gray-900">{{ number_format($employee->salaire, 0, ',', ' ') }} <span class="text-xs text-gray-500 font-normal">FCFA</span></p>
                    </div>
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-xs text-gray-400">* Les déductions (CNPS, Impôts) seront ajoutées au module Paie.</p>
                    </div>
                </div>

                <!-- NOUVEAU BLOC : Gestion des Documents -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Documents RH</h3>
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-3 text-green-700 text-xs">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('employees.uploadContrat', $employee->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contrat de travail (PDF)</label>
                        <input type="file" name="contrat" accept=".pdf" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <button type="submit" class="mt-3 w-full bg-gray-800 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-gray-900">
                            Enregistrer le document
                        </button>
                    </form>

                    @if($employee->contrat_file)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('employees.downloadContrat', $employee->id) }}" class="flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                <i class="fas fa-file-pdf text-red-500 text-lg mr-2"></i>
                                Télécharger le contrat PDF
                            </a>
                        </div>
                    @else
                        <p class="text-xs text-gray-400 mt-2">Aucun contrat uploadé.</p>
                    @endif
                </div>

            </div>

            <!-- Colonne de droite : Historique des congés -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6 h-full">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Historique des Congés</h3>
                        <span class="text-xs text-gray-500">{{ $leaves->count() }} demande(s) au total</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($leaves as $leave)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $leave->type }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Du {{ $leave->start_date->format('d/m/Y') }} <br>
                                            <span class="text-xs">au {{ $leave->end_date->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500">{{ $leave->reason ?? '-' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($leave->status == 'en_attente') bg-yellow-100 text-yellow-800
                                                @elseif($leave->status == 'approuve') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $leave->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                            Cet employé n'a pas encore de demande de congé.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- NOUVEAU SYSTEME D'ONGLETS POUR LA MESSAGERIE -->
        <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden">
            
            <!-- En-tête des onglets -->
            <div class="flex border-b border-gray-200 bg-gray-50">
                <button onclick="switchTab('historique')" id="tab-historique" class="px-6 py-4 text-sm font-medium text-green-700 border-b-2 border-green-600">
                    <i class="fas fa-comments mr-2"></i> Historique des messages
                </button>
                
                <!-- ON LE MASQUE SI C'EST L'EMPLOYÉ QUI REGARDE SON PROPRE PROFIL -->
                @if(Auth::user()->role === 'admin' || Auth::id() !== $employee->id)
                <button onclick="switchTab('ecrire')" id="tab-ecrire" class="px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700">
                    <i class="fas fa-pen-to-square mr-2"></i> Écrire un message
                </button>
                @endif
            </div>

            <!-- Contenu de l'onglet 1 : Historique -->
            <div id="content-historique" class="p-6">
                <div class="space-y-3">
                    @forelse($messages as $msg)
                        <div class="p-4 rounded-lg border flex items-start space-x-4">
                            <div class="mt-1">
                                @if($msg->is_read)
                                    <i class="fas fa-check-double text-gray-400 text-sm" title="Lu"></i>
                                @else
                                    <i class="fas fa-circle text-indigo-600 text-xs" title="Non lu"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h4 class="text-sm font-bold text-gray-900">{{ $msg->subject }}</h4>
                                    <span class="text-xs text-gray-400">{{ $msg->created_at->format('d/m/Y à H:i') }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $msg->content }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Aucun message envoyé à cet employé.</p>
                    @endforelse
                </div>
            </div>

            <!-- Contenu de l'onglet 2 : Formulaire (Caché par défaut et masqué pour l'employé) -->
            @if(Auth::user()->role === 'admin' || Auth::id() !== $employee->id)
            <div id="content-ecrire" class="p-6 hidden">
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('messages.send', $employee->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sujet</label>
                        <input type="text" name="subject" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Ex: Rappel documents manquants">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea name="content" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Bonjour, veuillez vous présenter au service RH muni de..."></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                        <i class="fas fa-paper-plane mr-2"></i> Envoyer
                    </button>
                </form>
            </div>
            @endif

        </div>

    </div>

    <!-- Script pour gérer les onglets sans recharger la page -->
    <script>
        function switchTab(tabName) {
            // Cacher tous les contenus
            document.getElementById('content-historique').classList.add('hidden');
            document.getElementById('content-ecrire').classList.add('hidden');
            
            // Remettre tous les onglets en gris
            document.getElementById('tab-historique').classList.remove('text-green-700', 'border-green-600');
            document.getElementById('tab-historique').classList.add('text-gray-500', 'border-transparent');
            
            document.getElementById('tab-ecrire').classList.remove('text-green-700', 'border-green-600');
            document.getElementById('tab-ecrire').classList.add('text-gray-500', 'border-transparent');

            // Afficher le contenu demandé et colorer l'onglet actif
            if(tabName === 'historique') {
                document.getElementById('content-historique').classList.remove('hidden');
                document.getElementById('tab-historique').classList.add('text-green-700', 'border-green-600');
                document.getElementById('tab-historique').classList.remove('text-gray-500', 'border-transparent');
            } else {
                document.getElementById('content-ecrire').classList.remove('hidden');
                document.getElementById('tab-ecrire').classList.add('text-green-700', 'border-green-600');
                document.getElementById('tab-ecrire').classList.remove('text-gray-500', 'border-transparent');
            }
        }
    </script>
</x-app-layout>