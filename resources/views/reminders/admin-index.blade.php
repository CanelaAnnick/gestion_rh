<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Bien-être & Rappels</h2>
                <p class="text-gray-500 mt-1">Anniversaires, échéances de contrats, événements.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <!-- Formulaire d'ajout rapide -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
            <form action="{{ route('reminders.store') }}" method="POST" class="flex flex-col md:flex-row gap-4">
                @csrf
                <input type="text" name="title" required placeholder="Ex: Anniversaire de Jean, Fin de CDD Marie..." class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                <input type="date" name="date_event" required class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                <select name="type" required class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    <option value="evenement">🗓️ Événement</option>
                    <option value="anniversaire">🎂 Anniversaire</option>
                    <option value="contrat">📄 Échéance Contrat</option>
                </select>
                <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i> Ajouter
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- COLONNE GAUCHE : À VENIR -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <span class="bg-emerald-100 text-emerald-700 p-2 rounded-lg mr-3"><i class="fas fa-clock"></i></span>
                    À venir
                </h3>
                <div class="space-y-4">
                    @forelse($upcomingReminders as $reminder)
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between {{ $reminder->is_read ? 'opacity-60' : '' }}">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl">
                                    {{ $reminder->type === 'anniversaire' ? '🎂' : ($reminder->type === 'contrat' ? '📄' : '🗓️') }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 {{ $reminder->is_read ? 'line-through' : '' }}">{{ $reminder->title }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $reminder->date_event->format('d/m/Y') }}
                                        <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold 
                                            {{ $reminder->type === 'anniversaire' ? 'bg-pink-100 text-pink-700' : ($reminder->type === 'contrat' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                                            {{ ucfirst($reminder->type) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('reminders.toggle', $reminder->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-emerald-500 hover:text-emerald-700" title="Marquer comme traité">
                                        <i class="fas fa-check-circle text-xl"></i>
                                    </button>
                                </form>
                                <form action="{{ route('reminders.destroy', $reminder->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-500" title="Supprimer">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-400 bg-white rounded-lg shadow-sm">
                            <i class="fas fa-check-double text-3xl mb-2"></i>
                            <p class="text-sm">Aucun rappel à venir.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- COLONNE DROITE : PASSÉS / ARCHIVES -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <span class="bg-gray-100 text-gray-700 p-2 rounded-lg mr-3"><i class="fas fa-archive"></i></span>
                    Passés / Archivés
                </h3>
                <div class="space-y-4">
                    @forelse($pastReminders as $reminder)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex items-center justify-between {{ !$reminder->is_read ? 'border-l-4 border-l-red-500' : 'opacity-60' }}">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl">
                                    {{ $reminder->type === 'anniversaire' ? '🎂' : ($reminder->type === 'contrat' ? '📄' : '🗓️') }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700 text-sm {{ $reminder->is_read ? 'line-through' : '' }}">{{ $reminder->title }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $reminder->date_event->format('d/m/Y') }}</p>
                                    @if(!$reminder->is_read)
                                        <span class="text-xs text-red-500 font-semibold">Non traité !</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('reminders.toggle', $reminder->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-gray-400 hover:text-emerald-600" title="Marquer comme traité">
                                        <i class="fas fa-check-circle text-xl"></i>
                                    </button>
                                </form>
                                <form action="{{ route('reminders.destroy', $reminder->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-500" title="Supprimer">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-400 bg-gray-50 rounded-lg">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p class="text-sm">Aucun historique.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>