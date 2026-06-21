<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Pointage du jour</h2>
            <p class="text-gray-500 mt-1">Suivi des arrivées et départs - {{ \Carbon\Carbon::parse($today)->locale('fr')->translatedFormat('l d F Y') }}</p>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure d'arrivée</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure de départ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($employees as $emp)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-9 w-9 rounded-full" src="https://ui-avatars.com/api/?name={{ $emp->name }}&background=16a34a&color=fff" alt="">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $emp->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $emp->poste }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($emp->statut === 'present')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Présent</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Absent</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($emp->heure_arrivee)
                                        <div class="font-medium">{{ \Carbon\Carbon::parse($emp->heure_arrivee)->format('H:i') }}</div>
                                        @if($emp->latitude)
                                            <a href="https://www.google.com/maps?q={{ $emp->latitude }},{{ $emp->longitude }}" target="_blank" class="text-xs text-indigo-600 hover:underline flex items-center mt-1">
                                                <i class="fas fa-map-marker-alt mr-1"></i> Voir position
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Pas de GPS (HTTP?)</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                    @if($emp->heure_arrivee)
                                        @if($emp->heure_depart)
                                            {{ \Carbon\Carbon::parse($emp->heure_depart)->format('H:i') }}
                                        @else
                                            <span class="text-green-600 text-xs font-bold">En cours...</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Aucun employé.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>