<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <a href="{{ route('formations.admin') }}" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium mb-4 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Retour
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Nouvelle Formation</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <form action="{{ route('formations.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Titre de la formation</label>
                        <input type="text" name="title" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500" placeholder="ex: Sécurité informatique">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500" placeholder="Détails du programme..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                            <input type="date" name="date_debut" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                            <input type="date" name="date_fin" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Formateur / Organisme</label>
                        <input type="text" name="formateur" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500" placeholder="ex: Jean Dupont ou Centre AFG">
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">Planifier</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>