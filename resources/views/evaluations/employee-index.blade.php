<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Mes Évaluations</h2>
            <p class="text-gray-500 mt-1">Consultez vos objectifs et vos retours de performance.</p>
        </div>

        <div class="space-y-6">
            @forelse($evaluations as $eval)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    
                    <!-- En-tête de la carte -->
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $eval->period }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Émise le {{ $eval->created_at->format('d/m/Y') }}</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full w-fit {{ $eval->status === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ $eval->status === 'en_attente' ? 'En cours' : 'Terminée' }}
                        </span>
                    </div>

                    <div class="p-6">
                        <!-- Objectifs -->
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Objectifs fixés</h4>
                            <p class="text-gray-700 bg-gray-50 p-4 rounded-lg text-sm">{{ $eval->objectifs }}</p>
                        </div>

                        <!-- Résultat (Visible uniquement si terminé) -->
                        @if($eval->status === 'terminee')
                            <div class="border-t border-gray-100 pt-6">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Appréciation du manager</h4>
                                
                                <div class="flex items-center mb-4">
                                    @php
                                        $texts = ['', 'Insuffisant', 'Passable', 'Bien', 'Très bien', 'Excellent'];
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-3xl {{ $i <= $eval->note ? 'text-yellow-400' : 'text-gray-200' }} mr-2"></i>
                                    @endfor
                                    <span class="ml-4 text-xl font-bold text-gray-700">{{ $eval->note }}/5</span>
                                    <span class="ml-2 text-sm font-medium text-yellow-600">({{ $texts[$eval->note] }})</span>
                                </div>

                                @if($eval->commentaires)
                                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg">
                                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $eval->commentaires }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Message si en cours -->
                            <div class="bg-blue-50 p-4 rounded-lg flex items-center text-blue-700 text-sm">
                                <i class="fas fa-clock mr-3 text-lg"></i>
                                <span>Vos objectifs sont en cours d'évaluation. Vous serez notifié lorsque le manager aura rempli son retour.</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-16 text-gray-400 bg-white rounded-xl shadow-sm">
                    <i class="fas fa-clipboard-list text-5xl mb-4"></i>
                    <p class="text-xl font-medium">Aucune évaluation pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>