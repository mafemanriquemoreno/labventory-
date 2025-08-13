<x-guest-layout>
    <div class="w-full bg-gray-900/70 backdrop-blur-sm rounded-2xl shadow-2xl p-8">

        <h2 class="text-2xl font-bold text-center text-white">
            Inicio de Sesión – LabVentory
        </h2>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="mt-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Correo electrónico corporativo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-envelope text-gray-400"></i>
                    </div>
                    <x-text-input id="email" class="block w-full pl-10 bg-gray-800/50 border-gray-600 text-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
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
                                    required autocomplete="current-password"
                                    placeholder="Mín. 8 caracteres" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded bg-gray-800/50 border-gray-600 text-cyan-600 shadow-sm focus:ring-cyan-500" name="remember">
                    <span class="ms-2 text-sm text-gray-400">Mantener sesión activa</span>
                </label>

                 @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-400 hover:text-gray-100 rounded-md" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <div class="flex flex-col items-center mt-6">
                {{--
                    INICIO DE LA MODIFICACIÓN
                    Aquí volvemos a añadir el botón de 'submit' que habíamos eliminado.
                --}}
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-transform transform hover:scale-105">
                    INGRESAR AL SISTEMA
                </button>
                {{-- FIN DE LA MODIFICACIÓN --}}


                <p class="mt-4 text-sm text-gray-400">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register') }}" class="font-medium text-cyan-500 hover:text-cyan-400">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>