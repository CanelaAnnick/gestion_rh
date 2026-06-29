<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Mes Formations</h2>
            <p class="text-gray-500 mt-1">Voici les sessions de formation prévues.</p>
        </div>

        <div class="space-y-6">
            @forelse($formations as $formation)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-start space-x-4">
                        <div class="bg-emerald-100 text-emerald-600 rounded-lg p-3 mt-1">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $formation->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $formation->description }}</p>
                            <div class="flex items-center space-x-4 mt-3 text-xs text-gray-400">
                                <span><i class="fas fa-calendar mr-1"></i> {{ $formation->date_debut ? $formation->date_debut->format('d/m/Y') : 'Date non définie' }}</span>
                                @if($formation->formateur)
                                    <span><i class="fas fa-user mr-1"></i> {{ $formation->formateur }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full w-fit bg-blue-100 text-blue-800 whitespace-nowrap">
                        {{ ucfirst(str_replace('_', ' ', $formation->status)) }}
                    </span>
                </div>
            @empty
                <div class="text-center py-16 text-gray-400 bg-white rounded-xl shadow-sm">
                    <i class="fas fa-calendar-check text-5xl mb-4"></i>
                    <p class="text-xl font-medium">Aucune formation prévue pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>