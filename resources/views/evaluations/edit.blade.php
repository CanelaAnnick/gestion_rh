<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <a href="{{ route('evaluations.admin') }}" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium mb-4 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Retour
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Noter l'évaluation</h2>
            <p class="text-gray-500 mt-1">Pour : <span class="font-semibold text-gray-700">{{ $evaluation->user->name }}</span> ({{ $evaluation->period }})</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            
            <!-- Rappel des objectifs -->
            <div class="bg-gray-50 p-4 rounded-lg mb-8 border-l-4 border-emerald-500">
                <h3 class="font-semibold text-gray-800 mb-2 text-sm uppercase tracking-wide">Objectifs définis</h3>
                <p class="text-gray-600 text-sm whitespace-pre-line">{{ $evaluation->objectifs }}</p>
            </div>

            <form action="{{ route('evaluations.update', $evaluation) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="space-y-8">
                    <!-- Système d'étoiles -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Note sur 5</label>
                        <div class="flex items-center space-x-2" id="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer text-gray-300 hover:text-yellow-400 transition">
                                    <input type="radio" name="note" value="{{ $i }}" class="hidden star-input" required>
                                    <i class="fas fa-star text-4xl"></i>
                                </label>
                            @endfor
                            <span id="note-text" class="ml-4 text-sm font-semibold text-gray-500">Sélectionnez une note</span>
                        </div>
                    </div>

                    <!-- Commentaires -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Commentaires / Feedback</label>
                        <textarea name="commentaires" rows="4" placeholder="Appréciation générale, points forts, axes d'amélioration..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('evaluations.admin') }}" class="px-6 py-3 rounded-lg font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition">Annuler</a>
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                        <i class="fas fa-check mr-2"></i> Valider et clôturer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Petit script pour rendre les étoiles interactives -->
    <script>
        const stars = document.querySelectorAll('.star-input');
        const noteText = document.getElementById('note-text');
        const texts = ['', 'Insuffisant', 'Passable', 'Bien', 'Très bien', 'Excellent'];

        stars.forEach(star => {
            star.addEventListener('change', function() {
                const val = parseInt(this.value);
                // Colorie les étoiles
                const labels = document.querySelectorAll('#star-rating label i');
                labels.forEach((label, index) => {
                    label.classList.toggle('text-yellow-400', index < val);
                    label.classList.toggle('text-gray-300', index >= val);
                });
                noteText.innerText = texts[val];
                noteText.classList.remove('text-gray-500');
                noteText.classList.add('text-yellow-600');
            });
        });
    </script>
</x-app-layout>