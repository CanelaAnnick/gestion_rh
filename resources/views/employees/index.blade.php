<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Liste du Personnel</h2>
                <p class="text-gray-500 mt-1">Gérez vos employés.</p>
            </div>
            <a href="{{ route('employees.create') }}" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i> Ajouter
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tableau -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                            <!-- CACHÉ SUR MOBILE -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Poste</th>
                            <!-- CACHÉ SUR MOBILE -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden lg:table-cell">Salaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($employees as $employee)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ $employee->name }}&background=16a34a&color=fff" alt="">
                                        <div class="ml-4">
                                            <!-- NOM CLIQUABLE -->
                                            <a href="{{ route('employees.show', $employee->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                                {{ $employee->name }}
                                            </a>
                                            <!-- On affiche l'email sous le nom sur mobile -->
                                            <div class="text-sm text-gray-500 md:hidden">{{ $employee->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <!-- CACHÉ SUR MOBILE -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">{{ $employee->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->poste }}</td>
                                <!-- CACHÉ SUR PETIT ÉCRAN -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 hidden lg:table-cell">{{ number_format($employee->salaire, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('employees.show', $employee->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Voir</a>
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="text-green-600 hover:text-green-900 mr-2">Mod</a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Supprimer ?')">Sup</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun employé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>