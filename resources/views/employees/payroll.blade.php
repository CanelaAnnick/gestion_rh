<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Gestion de la Paie</h2>
            <p class="text-gray-500 mt-1">Consultez et générez les bulletins de paie de vos employés.</p>
        </div>

        <!-- Résumé Masse Salariale -->
        <div class="bg-green-800 text-white rounded-xl shadow-sm p-6 mb-8 flex items-center justify-between">
            <div>
                <p class="text-green-200 text-sm">Masse Salariale Totale (Brut)</p>
                <p class="text-3xl font-bold mt-1">{{ number_format($totalMasseSalariale, 0, ',', ' ') }} FCFA</p>
            </div>
            <div class="bg-green-700 p-4 rounded-lg">
                <i class="fas fa-coins text-3xl text-green-200"></i>
            </div>
        </div>

        <!-- Liste des employés -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Département</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salaire Brut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($employees as $employee)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-9 w-9 rounded-full" src="https://ui-avatars.com/api/?name={{ $employee->name }}&background=16a34a&color=fff" alt="">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $employee->name }}</p>
                                            <p class="text-xs text-gray-500 md:hidden">{{ $employee->departement }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">{{ $employee->departement }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ number_format($employee->salaire, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('employees.payslip', $employee->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-file-pdf text-red-500 mr-1.5"></i> Voir Bulletin
                                    </a>
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