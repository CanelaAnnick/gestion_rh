<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8 bg-gray-100">
        <!-- Container centré et limité en largeur (le correctif) -->
        <div class="max-w-md w-full bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <div class="px-6 py-8 sm:px-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Mot de passe oublié ?</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Pas de souci, entrez votre email et on vous envoie un lien de réinitialisation.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            value="{{ old('email') }}"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Envoyer le lien de réinitialisation
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <a href="{{ route('login') }}" class="text-sm text-green-600 hover:text-green-500 font-medium">
                    Retour à la connexion
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>