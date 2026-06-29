<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <a href="{{ route('jobs.admin') }}" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium mb-4 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Retour aux offres
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Candidatures pour : {{ $job->title }}</h2>
            <p class="text-gray-500 mt-1">Département : {{ $job->department }} ({{ $job->type }})</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidat</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes RH</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">CV</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($candidatures as $candidature)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <div class="font-medium text-gray-900">{{ $candidature->first_name }} {{ $candidature->last_name }}</div>
                                <div class="text-xs text-gray-400 mt-1">Le {{ $candidature->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">
                                <div>{{ $candidature->email }}</div>
                                <div class="text-xs">{{ $candidature->phone }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <!-- Formulaire pour changer le statut -->
                                <form action="{{ route('candidatures.update', $candidature->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-semibold rounded-full px-2.5 py-1 border-0 focus:ring-2 focus:ring-emerald-500 
                                        {{ $candidature->status === 'nouveau' ? 'bg-gray-100 text-gray-800' : 
                                           ($candidature->status === 'entretien' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($candidature->status === 'retenu' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                        <option value="nouveau" {{ $candidature->status === 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                                        <option value="entretien" {{ $candidature->status === 'entretien' ? 'selected' : '' }}>Entretien</option>
                                        <option value="retenu" {{ $candidature->status === 'retenu' ? 'selected' : '' }}>Retenu</option>
                                        <option value="refuse" {{ $candidature->status === 'refuse' ? 'selected' : '' }}>Refusé</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-4">
                                <!-- Formulaire pour ajouter une note -->
                                <form action="{{ route('candidatures.update', $candidature->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $candidature->status }}">
                                    <input type="text" name="notes" value="{{ $candidature->notes }}" placeholder="Ajouter une note..." 
                                           class="w-full text-xs border border-gray-200 rounded px-2 py-1 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500"
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                @if($candidature->status === 'retenu')
                                    <a href="{{ route('candidatures.onboarding', $candidature->id) }}" class="text-indigo-600 hover:text-indigo-800" title="Démarrer l'intégration">
                                        <i class="fas fa-clipboard-check text-lg"></i>
                                    </a>
                                @endif
                                <a href="{{ route('candidatures.downloadCv', $candidature->id) }}" class="text-emerald-600 hover:text-emerald-800" title="Télécharger le CV">
                                    <i class="fas fa-file-pdf text-lg"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300 block"></i>
                                Aucune candidature reçue pour cette offre.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>