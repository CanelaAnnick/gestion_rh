<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 font-sans">
        <div class="flex w-full max-w-5xl bg-white shadow-2xl rounded-2xl overflow-hidden m-4">
            
            <!-- Côté Gauche : Branding (Style Cameroun/Entreprise Moderne) -->
            <div class="hidden md:flex w-1/2 bg-gradient-to-br from-green-600 to-green-800 flex-col justify-between p-12 text-white relative overflow-hidden">
                
                <!-- Décoration de fond -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full -translate-x-1/3 translate-y-1/3"></div>

                <div class="relative z-10 mt-10">
                    <h1 class="text-4xl font-extrabold tracking-tight mb-4">Gestion RH</h1>
                    <p class="text-green-100 text-lg leading-relaxed">
                        Simplifiez la gestion de votre personnel au Cameroun. 
                        Paie, congés et dossiers administratifs centralisés.
                    </p>
                </div>

                <div class="relative z-10 space-y-6 bg-white/10 p-6 rounded-xl backdrop-blur-sm border border-white/20">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-white/20 p-2 rounded-lg">
                            <i class="fas fa-money-bill-wave text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold">Gestion de la Paie (FCFA)</h3>
                            <p class="text-sm text-green-100">Calculs automatiques selon le code de travail camerounais.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-white/20 p-2 rounded-lg">
                            <i class="fas fa-users-cog text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold">Suivi des Congés</h3>
                            <p class="text-sm text-green-100">Validation rapide des demandes de vos employés.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Côté Droite : Formulaire -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                
                <div class="md:hidden mb-6 text-center">
                    <h1 class="text-2xl font-bold text-green-800">Gestion RH</h1>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Connexion</h2>
                    <p class="text-gray-500 mt-2">Accédez à votre espace administrateur ou employé.</p>
                </div>

                <!-- Formulaire Laravel (Back-end intégré) -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="far fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm transition duration-150 ease-in-out" 
                                placeholder="ex: admin@gestion-rh.cm">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" type="password" name="password" required
                                class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm transition duration-150 ease-in-out" 
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                Se souvenir de moi
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500">
                                Mot de passe oublié ?
                            </a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-transform transform hover:scale-[1.01]">
                            Se connecter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>