<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <a href="{{ route('evaluations.admin') }}" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium mb-4 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Retour
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Nouvelle évaluation</h2>
            <p class="text-gray-500 mt-1">Définissez les objectifs pour l'employé.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <form action="{{ route('evaluations.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Employé à évaluer</label>
                        <select name="user_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Sélectionner un employé...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->department ?? 'Non défini' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Période concernée</label>
                        <input type="text" name="period" required placeholder="ex: Trimestre 1 2024, Année 2024..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Objectifs à atteindre</label>
                        <textarea name="objectifs" rows="5" required placeholder="Décrivez les objectifs clairs pour cette période..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                        Lancer l'évaluation
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>