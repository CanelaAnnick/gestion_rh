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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($candidatures as $candidature)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $candidature->first_name }} {{ $candidature->last_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div>{{ $candidature->email }}</div>
                                <div class="text-xs">{{ $candidature->phone }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $candidature->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('candidatures.downloadCv', $candidature->id) }}" class="text-emerald-600 hover:text-emerald-800">
                                    <i class="fas fa-download mr-1"></i> Télécharger le CV
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
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