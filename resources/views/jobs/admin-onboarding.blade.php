<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <a href="{{ route('candidatures.index', $candidature->job_id) }}" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium mb-4 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Retour aux candidatures
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Checklist d'intégration</h2>
            <p class="text-gray-500 mt-1">Pour : <span class="font-semibold text-gray-700">{{ $candidature->first_name }} {{ $candidature->last_name }}</span> ({{ $candidature->job->title }})</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            
            <!-- Barre de progression globale -->
            <div class="mb-8">
                <div class="flex justify-between text-sm mb-2">
                    <span class="font-medium text-gray-700">Progression de l'intégration</span>
                    <span class="font-medium text-emerald-600" id="progress-text">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progress-bar" class="bg-emerald-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <!-- La Liste des tâches -->
            <!-- J'ai ajouté "onboarding-task" pour que le JS les reconnaisse facilement -->
            <ul class="space-y-4">
                @foreach($tasks as $taskName => $isChecked)
                    <li class="onboarding-task flex items-center p-4 rounded-lg border {{ $isChecked ? 'bg-emerald-50 border-emerald-200' : 'bg-white border-gray-200 hover:bg-gray-50' }} transition cursor-pointer"
                        data-task-name="{{ $taskName }}"
                        onclick="toggleTask(this)">
                        
                        <div class="flex-shrink-0">
                            @if($isChecked)
                                <div class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            @else
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300"></div>
                            @endif
                        </div>
                        
                        <span class="ml-4 text-base font-medium {{ $isChecked ? 'text-emerald-800 line-through' : 'text-gray-700' }}">
                            {{ $taskName }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        // On attend que la page soit chargée
        document.addEventListener("DOMContentLoaded", function() {
            updateProgressBar();
        });

        function toggleTask(element) {
            const taskName = element.getAttribute('data-task-name');
            const candidatureId = "{{ $candidature->id }}";
            
            // 1. On change l'affichage IMMÉDIATEMENT (même si le serveur est lent)
            const iconDiv = element.querySelector('div > div');
            const textSpan = element.querySelector('span');
            const isCurrentlyChecked = iconDiv.classList.contains('bg-emerald-500');
            
            if (isCurrentlyChecked) {
                element.classList.remove('bg-emerald-50', 'border-emerald-200');
                element.classList.add('bg-white', 'border-gray-200');
                iconDiv.className = 'w-6 h-6 rounded-full border-2 border-gray-300';
                iconDiv.innerHTML = '';
                textSpan.classList.remove('text-emerald-800', 'line-through');
                textSpan.classList.add('text-gray-700');
            } else {
                element.classList.remove('bg-white', 'border-gray-200');
                element.classList.add('bg-emerald-50', 'border-emerald-200');
                iconDiv.className = 'w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center';
                iconDiv.innerHTML = '<i class="fas fa-check text-white text-xs"></i>';
                textSpan.classList.remove('text-gray-700');
                textSpan.classList.add('text-emerald-800', 'line-through');
            }
            
            // 2. On met à jour la barre de progression IMMÉDIATEMENT
            updateProgressBar();

            // 3. On envoie la demande au serveur en arrière-plan
            fetch(`/admin/candidatures/${candidatureId}/onboarding-update`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ task_name: taskName })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur serveur');
                }
                return response.json();
            })
            .catch(error => {
                console.error('Erreur de sauvegarde:', error);
                alert('Une erreur est survenue lors de la sauvegarde. Vérifiez votre connexion.');
            });
        }

        function updateProgressBar() {
            const totalTasks = document.querySelectorAll('.onboarding-task').length;
            const completedTasks = document.querySelectorAll('.onboarding-task .fa-check').length;
            const percentage = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
            
            document.getElementById('progress-bar').style.width = percentage + '%';
            document.getElementById('progress-text').innerText = percentage + '%';
        }
    </script>
</x-app-layout>