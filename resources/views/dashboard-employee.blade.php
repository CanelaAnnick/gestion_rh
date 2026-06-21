<x-app-layout>
    
    <div class="max-w-5xl mx-auto">
        
        <!-- Message de bienvenue -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Bienvenue, {{ Auth::user()->name }} 👋</h1>
            <p class="text-gray-500 mt-1">Voici votre espace personnel. Gérez vos demandes de congés ici.</p>
        </div>

        <!-- Cartes d'informations personnelles -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                <p class="text-sm text-gray-500">Mon Poste</p>
                <p class="text-lg font-bold text-gray-900 mt-1">{{ Auth::user()->poste }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                <p class="text-sm text-gray-500">Mon Département</p>
                <p class="text-lg font-bold text-gray-900 mt-1">{{ Auth::user()->departement }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                <p class="text-sm text-gray-500">Solde de Congés Restant</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ Auth::user()->leave_balance }} <span class="text-sm text-gray-500 font-normal">jours</span></p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500 flex flex-col justify-between">
                <div>
                    <p class="text-sm text-gray-500">Paie</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">{{ number_format(Auth::user()->salaire, 0, ',', ' ') }} <span class="text-xs text-gray-500 font-normal">FCFA</span></p>
                </div>
                <a href="{{ route('employee.mypayslip') }}" class="mt-4 flex justify-center items-center bg-indigo-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                    <i class="fas fa-file-invoice-dollar mr-2"></i> Voir mon bulletin
                </a>
            </div>

        </div>

        <!-- SECTION : Messages de la Direction -->
        <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-envelope-open-text text-indigo-500 mr-3"></i> Messages de la Direction
            </h3>
            
            <div class="space-y-3" id="messages-list">
                @php 
                    $messages = App\Models\Message::where('user_id', Auth::id())
                                        ->orderBy('is_read', 'asc')
                                        ->orderBy('created_at', 'desc')
                                        ->get(); 
                @endphp

                @forelse($messages as $msg)
                    <div class="p-4 rounded-lg border {{ $msg->is_read ? 'bg-white border-gray-200' : 'bg-indigo-50 border-indigo-200' }} cursor-pointer message-item" data-id="{{ $msg->id }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-bold text-gray-900">
                                    @if(!$msg->is_read)<span class="inline-block w-2 h-2 bg-indigo-600 rounded-full mr-2"></span>@endif
                                    {{ $msg->subject }}
                                </h4>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($msg->content, 100) }}</p>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap ml-4">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="hidden mt-3 pt-3 border-t border-gray-200 text-sm text-gray-700 message-body">
                            {{ $msg->content }}
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">Aucun message pour le moment.</p>
                @endforelse
            </div>
        </div>

        <!-- SECTION : Pointage Sécurisé par GPS -->
        <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-map-marker-alt text-green-500 mr-3"></i> Mon Pointage du jour (Géolocalisé)
            </h3>
            <p class="text-xs text-gray-400 mb-4 bg-gray-50 p-2 rounded">⚡ La localisation de votre appareil sera vérifiée pour valider votre présence.</p>
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 text-sm">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- Bouton Arrivée -->
                <form id="form-checkin" action="{{ route('presence.checkin') }}" method="POST">
                    @csrf
                    <input type="hidden" name="latitude" id="lat-in" value="">
                    <input type="hidden" name="longitude" id="lng-in" value="">
                    <button type="button" onclick="handlePointage('form-checkin', 'lat-in', 'lng-in')" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-6 rounded-xl transition transform hover:scale-105 flex flex-col items-center justify-center disabled:opacity-50" id="btn-checkin">
                        <i class="fas fa-sign-in-alt text-3xl mb-2"></i>
                        Arrivée
                        <span class="text-xs font-normal opacity-80">{{ now()->format('H:i') }}</span>
                    </button>
                </form>

                <!-- Bouton Départ -->
                <form id="form-checkout" action="{{ route('presence.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="latitude" id="lat-out" value="">
                    <input type="hidden" name="longitude" id="lng-out" value="">
                    <button type="button" onclick="handlePointage('form-checkout', 'lat-out', 'lng-out')" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-6 rounded-xl transition transform hover:scale-105 flex flex-col items-center justify-center disabled:opacity-50" id="btn-checkout">
                        <i class="fas fa-sign-out-alt text-3xl mb-2"></i>
                        Départ
                        <span class="text-xs font-normal opacity-80">{{ now()->format('H:i') }}</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- SECTION : Formulaire et Historique des congés -->
        <div id="section-conges" class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            
            <!-- Formulaire de demande de congé -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Nouvelle demande de congé</h3>
                
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('leaves.store') }}" method="POST" class="space-y-4 mt-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type de congé</label>
                        <select name="type" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            <option value="Congé Annuel">Congé Annuel</option>
                            <option value="Maladie">Maladie</option>
                            <option value="Maternité">Maternité</option>
                            <option value="Personnel">Personnel</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date début</label>
                            <input type="date" name="start_date" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date fin</label>
                            <input type="date" name="end_date" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Motif (Optionnel)</label>
                        <textarea name="reason" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Expliquez brièvement la raison..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-700 transition">
                        Envoyer la demande
                    </button>
                </form>
            </div>

            <!-- Historique de mes congés -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Mon historique de congés</h3>
                
                <div class="space-y-3 mt-4">
                    @forelse($myLeaves as $leave)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $leave->type }}</p>
                                <p class="text-xs text-gray-500">
                                    Du {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($leave->status == 'en_attente') bg-yellow-100 text-yellow-800
                                @elseif($leave->status == 'approuve') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $leave->status)) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-8">Aucune demande de congé pour le moment.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</x-app-layout>

@push('scripts')
<script>
function handlePointage(formId, latId, lngId) {
    var btnId = formId.split('-')[1] === 'checkin' ? 'btn-checkin' : 'btn-checkout';
    var btn = document.getElementById(btnId);
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-2xl mb-2"></i> Vérification...';

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById(latId).value = position.coords.latitude;
                document.getElementById(lngId).value = position.coords.longitude;
                document.getElementById(formId).submit();
            },
            function(error) {
                // Si le GPS est bloqué (normal en local), on envoie quand même le formulaire
                document.getElementById(formId).submit();
            },
            { enableHighAccuracy: true, timeout: 5000 }
        );
    } else {
        document.getElementById(formId).submit();
    }
}
</script>
@endpush