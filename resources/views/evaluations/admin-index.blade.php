<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Évaluations</h2>
                <p class="text-gray-500 mt-1">Suivez les performances de vos employés.</p>
            </div>
            <a href="{{ route('evaluations.create') }}" class="bg-emerald-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                <i class="fas fa-plus mr-2"></i> Nouvelle évaluation
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Note</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($evaluations as $eval)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm mr-3">
                                        {{ strtoupper(substr($eval->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $eval->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $eval->period }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $eval->status === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $eval->status === 'en_attente' ? 'En attente' : 'Terminée' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-yellow-500">
                                @if($eval->note)
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $eval->note ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                                    @endfor
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                @if($eval->status === 'en_attente')
                                    <a href="{{ route('evaluations.edit', $eval) }}" class="text-emerald-600 hover:text-emerald-800">
                                        <i class="fas fa-star-half-alt mr-1"></i> Noter
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">Complétée</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-clipboard-list text-4xl mb-3 text-gray-300 block"></i>
                                Aucune évaluation pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>