<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-4xl font-bold text-white">Crear Cuenta</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <x-input-label for="name" value="Nombre Completo" class="text-white/80" />
            <x-text-input id="name" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-white/50" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="email" value="Correo Electrónico" class="text-white/80" />
            <x-text-input id="email" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-white/50" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" class="text-white/80" />
            <x-text-input id="password" class="block mt-1 w-full bg-white/20 border-white/30 text-white" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" class="text-white/80" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white/20 border-white/30 text-white" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full justify-center text-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Registrarse
            </button>
        </div>
        <div class="text-center mt-4">
             <p class="text-sm text-gray-300">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="font-medium text-white hover:underline">
                    Inicia sesión
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
