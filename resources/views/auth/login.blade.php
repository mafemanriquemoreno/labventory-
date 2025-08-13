<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-4xl font-bold text-white">Iniciar Sesión</h2>
    </div>
    
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <x-input-label for="email" value="Correo Electrónico" class="text-white/80" />
            <x-text-input id="email" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-white/50" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" class="text-white/80" />
            <x-text-input id="password" class="block mt-1 w-full bg-white/20 border-white/30 text-white" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-300">{{ __('Recordarme') }}</span>
            </label>
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full justify-center text-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Iniciar Sesión
            </button>
        </div>
        <div class="text-center mt-4">
             <p class="text-sm text-gray-300">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="font-medium text-white hover:underline">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
