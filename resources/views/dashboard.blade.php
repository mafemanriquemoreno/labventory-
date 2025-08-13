<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- INICIO: CONTENEDOR DE LAS TARJETAS DE ESTADÍSTICAS --}}
            {{-- Usamos un grid para crear 5 columnas en escritorio y menos en móvil --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">

                {{-- Tarjeta 1: Elementos Únicos --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Elementos Únicos</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalItems }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Tipos de productos</p>
                </div>

                {{-- Tarjeta 2: Sin Stock --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Sin Stock</h3>
                    <p class="mt-1 text-3xl font-semibold text-red-500">{{ $itemsOutOfStock }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Ítems agotados</p>
                </div>

                {{-- Tarjeta 3: Stock Bajo --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Stock Bajo</h3>
                    <p class="mt-1 text-3xl font-semibold text-orange-500">{{ $itemsWithLowStock }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Debajo del umbral</p>
                </div>

                {{-- Tarjeta 4: Próximos a Vencer --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Próximos a Vencer</h3>
                    {{-- La variable es una colección, así que usamos count() para obtener el número --}}
                    <p class="mt-1 text-3xl font-semibold text-blue-500">{{ $itemsNearExpiration->count() }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Vencen en menos de 30 días</p>
                </div>

                {{-- Tarjeta 5: Valor del Inventario --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Valor del Inventario</h3>
                    {{-- Formateamos el número como moneda --}}
                    <p class="mt-1 text-3xl font-semibold text-green-500">${{ number_format($inventoryValue, 2, ',', '.') }}</p>
                     <p class="text-xs text-gray-500 dark:text-gray-400">Costo total de ítems</p>
                </div>

            </div>
            {{-- FIN: CONTENEDOR DE LAS TARJETAS DE ESTADÍSTICAS --}}

            {{-- Aquí añadiremos las tablas de alertas en el siguiente paso --}}

        </div>
    </div>
</x-app-layout>