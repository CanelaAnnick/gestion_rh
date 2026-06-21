<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrières - Gestion RH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    
    <!-- En-tête public épuré -->
    <div class="bg-emerald-800 text-white py-16 text-center">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl font-bold tracking-tight">Rejoignez notre équipe</h1>
            <p class="mt-4 text-emerald-100 text-lg max-w-2xl mx-auto">Nous recherchons des talents passionnés pour accompagner notre croissance. Découvrez nos opportunités ci-dessous.</p>
        </div>
    </div>

    <!-- Liste des offres -->
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
                                <span><i class="fas fa-map-marker-alt mr-1"></i> Douala</span>
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
                        
                        <!-- BOUTON POSTULER CORRIGE : Envoie un mail au lieu d'aller sur le dashboard -->
                        <a href="mailto:recrutement@gestionrh.com?subject=Candidature pour le poste de {{ $job->title }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-md text-sm font-semibold shadow-sm transition-colors">
                            Postuler maintenant
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 text-gray-400 bg-white rounded-lg shadow-sm">
                    <i class="fas fa-briefcase text-5xl mb-4"></i>
                    <p class="text-xl font-medium">Aucune offre disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>