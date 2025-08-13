<x-guest-layout>
    {{-- Usamos la misma tarjeta flotante y semitransparente del login --}}
    <div class="w-full bg-gray-900/70 backdrop-blur-sm rounded-2xl shadow-2xl p-8">

        <h2 class="text-2xl font-bold text-center text-white">
            Crear Nueva Cuenta
        </h2>

        <form method="POST" action="{{ route('register') }}" class="mt-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-300">Nombre Completo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-user text-gray-400"></i>
                    </div>
                    <x-text-input id="name" class="block w-full pl-10 bg-gray-800/50 border-gray-600 text-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-300">Correo electrónico</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-envelope text-gray-400"></i>
                    </div>
                    <x-text-input id="email" class="block w-full pl-10 bg-gray-800/50 border-gray-600 text-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                <div class="relative mt-1">
                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input id="password" class="block w-full pl-10 bg-gray-800/50 border-gray-600 text-white"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password"
                                    placeholder="Mín. 8 caracteres" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirmar Contraseña</label>
                 <div class="relative mt-1">
                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input id="password_confirmation" class="block w-full pl-10 bg-gray-800/50 border-gray-600 text-white"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>


            <div class="flex flex-col items-center mt-6">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-transform transform hover:scale-105">
                    REGISTRARSE
                </button>

                <p class="mt-4 text-sm text-gray-400">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" class="font-medium text-cyan-500 hover:text-cyan-400">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>