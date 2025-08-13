<x-guest-layout>
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-3">Bienvenido</h2>
        <p class="text-gray-500 mb-8">Accede a tu cuenta o crea una nueva para empezar.</p>
    </div>

    <div class="space-y-4">
        <a href="{{ route('login') }}" class="block w-full text-center bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-300">
            Iniciar Sesión
        </a>
        <a href="{{ route('register') }}" class="block w-full text-center bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-300 transition duration-300">
            Registrarse
        </a>
    </div>
</x-guest-layout>
