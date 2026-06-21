<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrières - Gestion RH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Petit style pour cacher/afficher le modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; justify-content: center; align-items: center; }
        .modal-overlay.active { display: flex; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    
    <div class="bg-emerald-800 text-white py-16 text-center">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl font-bold tracking-tight">Rejoignez notre équipe</h1>
            <p class="mt-4 text-emerald-100 text-lg max-w-2xl mx-auto">Nous recherchons des talents passionnés. Découvrez nos opportunités.</p>
        </div>
    </div>

    <div id="offres" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-8 text-emerald-700 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            @forelse($jobs as $job)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $job->title }}</h2>
                            <div class="flex flex-wrap items-center gap-3 mt-3 text-sm text-gray-500">
                                <span><i class="fas fa-building mr-1"></i> {{ $job->department }}</span>
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $job->type }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">{{ Str::limit($job->description, 200) }}</p>
                    
                    @if($job->requirements)
                        <div class="bg-gray-50 border-l-4 border-emerald-500 p-4 rounded-r-lg text-sm mb-4">
                            <p class="font-semibold text-gray-700 mb-1">Compétences requises :</p>
                            <p class="text-gray-600">{{ Str::replace('-', ', ', $job->requirements) }}</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-end mt-6 pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">Publié le {{ $job->verified_at ? $job->verified_at->format('d/m/Y') : 'Récemment' }}</span>
                        
                        <!-- BOUTON QUI OUVRE LE MODAL -->
                        <button onclick="openModal({{ $job->id }}, '{{ $job->title }}')" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-md text-sm font-semibold shadow-sm transition-colors">
                            Postuler maintenant
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 text-gray-400 bg-white rounded-lg shadow-sm">
                    <i class="fas fa-briefcase text-5xl mb-4"></i>
                    <p class="text-xl font-medium">Aucune offre disponible.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- LE MODAL (FENETRE DE CANDIDATURE) -->
    <div id="applicationModal" class="modal-overlay">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 p-6 relative">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <h3 class="text-xl font-bold text-gray-900 mb-1">Postuler</h3>
            <p class="text-sm text-gray-500 mb-6">Pour le poste : <span id="modalJobTitle" class="font-semibold text-emerald-600"></span></p>

            <form id="applicationForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="first_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="last_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="text" name="phone" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Votre CV (PDF, Word)</label>
                    <input type="file" name="cv" required accept=".pdf,.doc,.docx" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
                <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                    Envoyer ma candidature
                </button>
            </form>
        </div>
    </div>

    <!-- Script pour gérer le modal -->
    <script>
        function openModal(jobId, jobTitle) {
            document.getElementById('modalJobTitle').innerText = jobTitle;
            document.getElementById('applicationForm').action = '/carrieres/' + jobId + '/postuler';
            document.getElementById('applicationModal').classList.add('active');
        }
        function closeModal() {
            document.getElementById('applicationModal').classList.remove('active');
        }
    </script>
</body>
</html>