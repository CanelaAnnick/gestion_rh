<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex justify-between items-center mb-6">
            <!-- LIEN INTELLIGENT : Retour différent si c'est l'admin ou l'employé -->
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('employees.show', $employee->id) }}" class="text-sm text-green-600 hover:text-green-500">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à la fiche
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="text-sm text-green-600 hover:text-green-500">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à mon espace
                </a>
            @endif
            
            <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-900 hidden md:inline-flex items-center">
                <i class="fas fa-print mr-2"></i> Imprimer
            </button>
        </div>

        <!-- Le Document Bulletin (Style Papier) -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 print:shadow-none print:border-0">
            
            <!-- En-tête de l'entreprise -->
            <div class="border-b-2 border-green-600 pb-4 mb-8">
                <div class="flex justify-between items-end">
                    <div>
                        <h1 class="text-2xl font-bold text-green-800">{{ $companyName ?? 'GestionRH Pro' }}</h1>
                        <p class="text-sm text-gray-500">Votre partenaire de confiance</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-bold text-gray-800">BULLETIN DE PAIE</h2>
                        <p class="text-sm text-gray-500 font-semibold">{{ $moisAnnee }}</p>
                    </div>
                </div>
            </div>

            <!-- Infos Employé -->
            <div class="grid grid-cols-2 gap-4 mb-8 bg-gray-50 p-4 rounded-lg">
                <div>
                    <p class="text-xs text-gray-500">Employé</p>
                    <p class="font-bold text-gray-900">{{ $employee->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Poste / Département</p>
                    <p class="font-bold text-gray-900">{{ $employee->poste }} ({{ $employee->departement }})</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Matricule (ID)</p>
                    <p class="font-bold text-gray-900">EMP-{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Tableau des calculs -->
            <table class="w-full mb-8 text-sm">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-3 text-left rounded-tl-lg">ÉLÉMENTS</th>
                        <th class="px-4 py-3 text-right rounded-tr-lg">MONTANT (FCFA)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Salaire Brut -->
                    <tr class="border-b border-gray-200">
                        <td class="px-4 py-3 font-medium text-gray-800">Salaire de Base</td>
                        <td class="px-4 py-3 text-right font-bold text-green-700">{{ number_format($salaireBrut, 0, ',', ' ') }}</td>
                    </tr>
                </tbody>
                
                <thead>
                    <tr class="bg-red-50">
                        <th class="px-4 py-2 text-left text-red-800 text-xs uppercase rounded-bl-lg">Déductions</th>
                        <th class="px-4 py-2 text-right text-red-800 text-xs uppercase rounded-br-lg">Retenues</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200 bg-white">
                        <td class="px-4 py-3 text-gray-600 pl-6">CNPS ({{ $cnpsRate * 100 }}%)</td>
                        <td class="px-4 py-3 text-right text-red-600">- {{ number_format($cnps, 0, ',', ' ') }}</td>
                    </tr>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <td class="px-4 py-3 text-gray-600 pl-6">Impôt sur le Revenu ({{ $taxRate * 100 }}%)</td>
                        <td class="px-4 py-3 text-right text-red-600">- {{ number_format($impot, 0, ',', ' ') }}</td>
                    </tr>
                    <tr class="border-b-4 border-double border-gray-800 bg-white">
                        <td class="px-4 py-3 font-bold text-gray-800">TOTAL DÉDUCTIONS</td>
                        <td class="px-4 py-3 text-right font-bold text-red-600">- {{ number_format($totalDeductions, 0, ',', ' ') }}</td>
                    </tr>
                </tbody>
                
                <tfoot>
                    <tr class="bg-green-700 text-white">
                        <td class="px-4 py-4 text-lg font-bold rounded-bl-lg">NET À PAYER</td>
                        <td class="px-4 py-4 text-lg font-bold text-right rounded-br-lg">{{ number_format($salaireNet, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Pied de page du bulletin -->
            <div class="mt-12 grid grid-cols-2 gap-8 text-center">
                <div>
                    <p class="text-sm text-gray-500 mb-8">Signature de l'Employé</p>
                    <div class="border-t border-gray-400 pt-2"></div>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-8">Signature du Responsable RH</p>
                    <div class="border-t border-gray-400 pt-2"></div>
                </div>
            </div>
            
            <p class="text-xs text-gray-400 text-center mt-8 border-t pt-4">
                *Document généré automatiquement par GestionRH Pro. Ce bulletin est une simulation.
            </p>
        </div>

        <!-- Bouton Imprimer Mobile -->
        <div class="mt-4 text-center md:hidden">
            <button onclick="window.print()" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-medium w-full">
                <i class="fas fa-print mr-2"></i> Imprimer le bulletin
            </button>
        </div>

    </div>

    <!-- CSS pour cacher la sidebar lors de l'impression -->
    <style>
        @media print {
            body * { visibility: hidden; }
            .print:shadow-none, .print:shadow-none * { visibility: visible; }
            .print:shadow-none { position: absolute; left: 0; top: 0; width: 100%; }
        }
    </style>
</x-app-layout>