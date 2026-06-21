<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Paramètres de l'application</h2>
            <p class="text-gray-500 mt-1">Modifiez les constantes utilisées pour générer les fiches de paie et le nom affiché sur les documents.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 text-sm">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm p-6">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Nom de l'entreprise -->
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise (sur les bulletins)</label>
                        <input type="text" name="company_name" id="company_name" value="{{ $settings['company_name'] ?? '' }}" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Taux CNPS -->
                    <div>
                        <label for="cnps_rate" class="block text-sm font-medium text-gray-700">Taux de cotisation CNPS (Employé en %)</label>
                        <div class="mt-1 flex rounded-lg shadow-sm">
                            <input type="number" step="0.1" name="cnps_rate" id="cnps_rate" value="{{ $settings['cnps_rate'] ?? '2.8' }}" required class="block w-full border-none px-4 py-3 sm:text-sm focus:outline-none">
                            <span class="flex items-center px-4 bg-gray-50 text-gray-500 text-sm border border-l-0 rounded-r-md">%</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Actuellement en France/Cameroun : 2.8%</p>
                    </div>

                    <!-- Taux Impôt -->
                    <div>
                        <label for="tax_rate" class="block text-sm font-medium text-gray-700">Taux d'imposition estimé (IR en %)</label>
                        <div class="mt-1 flex rounded-lg shadow-sm">
                            <input type="number" step="0.1" name="tax_rate" id="tax_rate" value="{{ $settings['tax_rate'] ?? '10' }}" required class="block w-full border-none px-4 py-3 sm:text-sm focus:outline-none">
                            <span class="flex items-center px-4 bg-gray-50 text-gray-500 text-sm border border-l-0 rounded-r-md">%</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Ce taux est une estimation forfaitaire pour le MVP.</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 transition">
                        Sauvegarder les modifications
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>