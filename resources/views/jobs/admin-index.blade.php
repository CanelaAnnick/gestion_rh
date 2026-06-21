<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Recrutement</h2>
                <p class="text-gray-500 mt-1">Gérez vos offres d'emploi et suivez les candidatures.</p>
            </div>
            <a href="{{ route('jobs.public') }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                <i class="fas fa-external-link-alt mr-1"></i> Voir la page publique
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <!-- Formulaire d'ajout -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
            <form action="{{ route('jobs.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <input type="text" name="title" required placeholder="Titre de l'offre" class="col-span-2 px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                    <select name="department" required class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                        <option value="">Département...</option>
                        <option value="Informatique">Informatique</option>
                        <option value="Ressources Humaines">Ressources Humaines</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Commercial">Commercial</option>
                    </select>
                    <select name="type" required class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                        <option value="">Type...</option>
                        <option value="CDI">CDI</option>
                        <option value="CDD">CDD</option>
                        <option value="Stage">Stage</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <textarea name="description" rows="2" required placeholder="Description du poste et missions..." class="col-span-2 px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"></textarea>
                    <input type="text" name="requirements" rows="2" placeholder="Exigences (ex: Laravel-MySQL-Git)" class="col-span-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition whitespace-nowrap">
                        <i class="fas fa-plus mr-2"></i> Publier
                    </button>
                </div>
            </form>
        </div>

        <!-- Tableau des offres -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Offre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Département</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $job->title }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($job->description, 60) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $job->department }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    // BUG CORRIGE : Cde remplacé par CDD
                                    $typeClass = $job->type === 'CDI' ? 'bg-yellow-100 text-yellow-800' : ($job->type === 'CDD' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800');
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $typeClass }}">{{ $job->type }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- NOUVEAU : Menu déroulant pour changer le statut -->
                                <form action="{{ route('jobs.updateStatus', $job->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-semibold rounded-full px-2.5 py-1 border-0 focus:ring-2 focus:ring-emerald-500 
                                        {{ $job->status === 'ouverte' ? 'bg-green-100 text-green-800' : ($job->status === 'pourvue' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        <option value="ouverte" {{ $job->status === 'ouverte' ? 'selected' : '' }}>Ouverte</option>
                                        <option value="pourvue" {{ $job->status === 'pourvue' ? 'selected' : '' }}>Pourvue</option>
                                        <option value="fermee" {{ $job->status === 'fermee' ? 'selected' : '' }}>Fermée</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                
                                <!-- PREPARATION CANDIDATURES (Grisé pour l'instant) -->
                                <button disabled class="text-gray-300 cursor-not-allowed mr-3" title="Bientôt disponible (Suivi des candidatures)">
                                    <i class="fas fa-users text-lg"></i>
                                </button>

                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Supprimer l'offre"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Aucune offre pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>