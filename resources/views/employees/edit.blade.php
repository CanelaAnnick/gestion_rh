<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Modifier Employé</h3>
                    <a href="{{ route('employees.index') }}" class="text-green-600 hover:text-green-500 text-sm font-medium mt-6 block">
                        &larr; Retour à la liste
                    </a>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <input type="text" name="name" id="name" value="{{ $employee->name }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ $employee->email }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="poste" class="block text-sm font-medium text-gray-700">Poste</label>
                                    <input type="text" name="poste" id="poste" value="{{ $employee->poste }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="departement" class="block text-sm font-medium text-gray-700">Département</label>
                                    <select id="departement" name="departement" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        <option value="RH" {{ $employee->departement == 'RH' ? 'selected' : '' }}>RH</option>
                                        <option value="IT" {{ $employee->departement == 'IT' ? 'selected' : '' }}>Informatique</option>
                                        <option value="Finance" {{ $employee->departement == 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Marketing" {{ $employee->departement == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                        <option value="Commercial" {{ $employee->departement == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                        <option value="Juridique" {{ $employee->departement == 'Juridique' ? 'selected' : '' }}>Juridique</option>
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="salaire" class="block text-sm font-medium text-gray-700">Salaire (FCFA)</label>
                                    <input type="number" name="salaire" id="salaire" value="{{ $employee->salaire }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                                    <select id="role" name="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        <option value="employee" {{ $employee->role == 'employee' ? 'selected' : '' }}>Employé</option>
                                        <option value="admin" {{ $employee->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe (Laisser vide pour ne pas changer)</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer mot de passe</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Mettre à jour
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>