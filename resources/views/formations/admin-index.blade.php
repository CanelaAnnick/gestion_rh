<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Plan de Formation</h2>
                <p class="text-gray-500 mt-1">Gérez les formations internes et externes.</p>
            </div>
            <a href="{{ route('formations.create') }}" class="bg-emerald-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                <i class="fas fa-plus mr-2"></i> Nouvelle formation
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($formations as $formation)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $formation->title }}</h3>
                        <form action="{{ route('formations.updateStatus', $formation->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs font-semibold rounded-full px-2 py-1 border-0 focus:ring-2 focus:ring-emerald-500 
                                {{ $formation->status === 'planifiee' ? 'bg-blue-100 text-blue-800' : ($formation->status === 'en_cours' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                <option value="planifiee" {{ $formation->status === 'planifiee' ? 'selected' : '' }}>Planifiée</option>
                                <option value="en_cours" {{ $formation->status === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminee" {{ $formation->status === 'terminee' ? 'selected' : '' }}>Terminée</option>
                            </select>
                        </form>
                    </div>
                    
                    <p class="text-sm text-gray-500 mb-4">{{ Str::limit($formation->description, 80) }}</p>
                    
                    <div class="border-t border-gray-100 pt-4 mt-auto space-y-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt w-5 text-center mr-2 text-gray-400"></i>
                            <span>{{ $formation->date_debut->format('d/m/Y') }} {{ $formation->date_fin ? '- ' . $formation->date_fin->format('d/m/Y') : '' }}</span>
                        </div>
                        @if($formation->formateur)
                        <div class="flex items-center">
                            <i class="fas fa-chalkboard-teacher w-5 text-center mr-2 text-gray-400"></i>
                            <span>{{ $formation->formateur }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 text-gray-400 bg-white rounded-xl shadow-sm">
                    <i class="fas fa-graduation-cap text-5xl mb-4"></i>
                    <p class="text-xl font-medium">Aucune formation planifiée.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>