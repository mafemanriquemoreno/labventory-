<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- CONTENEDOR DE LAS TARJETAS DE ESTADÍSTICAS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">

                {{-- Tarjeta 1: Elementos Únicos --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 flex items-center">
                    <div class="bg-indigo-500 bg-opacity-20 rounded-full p-3">
                        <i class="fa-solid fa-flask-vial fa-2x text-indigo-500"></i>
                    </div>
                    <div class="ms-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Elementos Únicos</h3>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalItems }}</p>
                    </div>
                </div>

                {{-- Tarjeta 2: Sin Stock --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-red-500 bg-opacity-20 rounded-full p-3">
                            <i class="fa-solid fa-ban fa-2x text-red-500"></i>
                        </div>
                        <div class="ms-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Sin Stock</h3>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $itemsOutOfStock }}</p>
                        </div>
                    </div>
                    <a href="{{ route('productos.index', ['status' => 'agotado']) }}" class="text-sm text-cyan-600 hover:text-cyan-500 mt-2 block">Gestionar ahora &rarr;</a>
                </div>

                {{-- Tarjeta 3: Stock Bajo --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                     <div class="flex items-center">
                        <div class="bg-orange-500 bg-opacity-20 rounded-full p-3">
                           <i class="fa-solid fa-triangle-exclamation fa-2x text-orange-500"></i>
                        </div>
                        <div class="ms-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock Bajo</h3>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $itemsWithLowStock }}</p>
                        </div>
                    </div>
                    <a href="{{ route('productos.index', ['status' => 'stock_bajo']) }}" class="text-sm text-cyan-600 hover:text-cyan-500 mt-2 block">Gestionar ahora &rarr;</a>
                </div>

                {{-- Tarjeta 4: Próximos a Vencer --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-blue-500 bg-opacity-20 rounded-full p-3">
                            <i class="fa-solid fa-calendar-times fa-2x text-blue-500"></i>
                        </div>
                        <div class="ms-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Próximos a Vencer</h3>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $itemsNearExpiration->count() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('productos.index') }}" class="text-sm text-cyan-600 hover:text-cyan-500 mt-2 block">Gestionar ahora &rarr;</a>
                </div>

                {{-- Tarjeta 5: Valor del Inventario --}}
                 <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 flex items-center">
                    <div class="bg-green-500 bg-opacity-20 rounded-full p-3">
                        <i class="fa-solid fa-dollar-sign fa-2x text-green-500"></i>
                    </div>
                    <div class="ms-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Valor Inventario</h3>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">${{ number_format($inventoryValue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{--
                INICIO DE LA MODIFICACIÓN: SECCIÓN DE ALERTAS ACTIVAS
                Reemplazamos el texto 'Próximamente...' con la lógica real.
            --}}
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Alertas Activas</h3>
                
                <div class="space-y-4">
                    {{-- Alerta: Elementos Sin Stock --}}
                    @if($outOfStockProducts->isNotEmpty())
                        <div x-data="{ open: false }" class="bg-red-500/10 p-4 rounded-lg">
                            <button @click="open = !open" class="w-full flex justify-between items-center text-left">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-ban text-red-500 mr-3"></i>
                                    <span class="font-semibold text-red-700 dark:text-red-300">Elementos Sin Stock ({{ $outOfStockProducts->count() }})</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm text-red-600 dark:text-red-400 mr-2">Ver Detalles</span>
                                    <i class="fa-solid fa-chevron-down transition-transform" :class="{'rotate-180': open}"></i>
                                </div>
                            </button>
                            <div x-show="open" x-transition class="mt-4">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr><th scope="col" class="px-6 py-3">Producto</th><th scope="col" class="px-6 py-3">Lote</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach($outOfStockProducts as $product)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"><td class="px-6 py-4">{{ $product->nombre_del_producto }}</td><td class="px-6 py-4">{{ $product->numero_de_lote }}</td></tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Alerta: Elementos Vencidos --}}
                    @if($expiredProducts->isNotEmpty())
                        <div x-data="{ open: false }" class="bg-red-500/10 p-4 rounded-lg">
                            <button @click="open = !open" class="w-full flex justify-between items-center text-left">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-calendar-xmark text-red-500 mr-3"></i>
                                    <span class="font-semibold text-red-700 dark:text-red-300">Elementos Vencidos ({{ $expiredProducts->count() }})</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm text-red-600 dark:text-red-400 mr-2">Ver Detalles</span>
                                    <i class="fa-solid fa-chevron-down transition-transform" :class="{'rotate-180': open}"></i>
                                </div>
                            </button>
                            <div x-show="open" x-transition class="mt-4">
                               <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr><th scope="col" class="px-6 py-3">Producto</th><th scope="col" class="px-6 py-3">Lote</th><th scope="col" class="px-6 py-3">Fecha Vencimiento</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach($expiredProducts as $product)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"><td class="px-6 py-4">{{ $product->nombre_del_producto }}</td><td class="px-6 py-4">{{ $product->numero_de_lote }}</td><td class="px-6 py-4">{{ \Carbon\Carbon::parse($product->fecha_de_vencimiento)->format('d-m-Y') }}</td></tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Alerta: Stock Bajo --}}
                    @if($lowStockProducts->isNotEmpty())
                        <div x-data="{ open: false }" class="bg-orange-500/10 p-4 rounded-lg">
                            <button @click="open = !open" class="w-full flex justify-between items-center text-left">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-triangle-exclamation text-orange-500 mr-3"></i>
                                    <span class="font-semibold text-orange-700 dark:text-orange-300">Stock Bajo ({{ $lowStockProducts->count() }})</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm text-orange-600 dark:text-orange-400 mr-2">Ver Detalles</span>
                                    <i class="fa-solid fa-chevron-down transition-transform" :class="{'rotate-180': open}"></i>
                                </div>
                            </button>
                            <div x-show="open" x-transition class="mt-4">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr><th scope="col" class="px-6 py-3">Producto</th><th scope="col" class="px-6 py-3">Stock Actual</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lowStockProducts as $product)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"><td class="px-6 py-4">{{ $product->nombre_del_producto }}</td><td class="px-6 py-4">{{ $product->cantidad_actual }} uds.</td></tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            {{-- FIN: SECCIÓN DE ALERTAS ACTIVAS --}}

        </div>
    </div>
</x-app-layout>