<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Départements</h2>
                <p class="text-gray-500 mt-1">Gérez les services de l'entreprise.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 text-sm">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            
            <!-- Formulaire d'ajout rapide -->
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <form action="{{ route('departments.store') }}" method="POST" class="flex flex-col md:flex-row gap-4">
                    @csrf
                    <input type="text" name="name" required placeholder="Nom du nouveau département (ex: Logistique)" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i> Ajouter
                    </button>
                </form>
            </div>

            <!-- Liste des départements -->
            <div class="divide-y divide-gray-200">
                @forelse($departments as $dept)
                    <div class="p-6 hover:bg-gray-50 transition flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center font-bold mr-4">
                                {{ strtoupper(substr($dept->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">{{ $dept->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $dept->description ?? 'Aucune description' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ ucfirst($dept->status) }}</span>
                            
                            <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" onsubmit="return confirm('Supprimer ce département ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 p-1">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-400">
                        <i class="fas fa-building text-4xl mb-3"></i>
                        <p>Aucun département créé.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>