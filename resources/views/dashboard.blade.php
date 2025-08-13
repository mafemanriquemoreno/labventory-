<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjetas de Métricas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Elementos Únicos</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalItems }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Items Sin Stock</h3>
                    <p class="text-3xl font-bold mt-2">{{ $itemsOutOfStock }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Items con Stock Bajo</h3>
                    <p class="text-3xl font-bold mt-2">{{ $itemsWithLowStock }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Próximos a Vencer</h3>
                    <p class="text-3xl font-bold mt-2">{{ $itemsNearExpiration->count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Valor del Inventario</h3>
                    <p class="text-3xl font-bold mt-2">${{ number_format($inventoryValue, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Alertas Activas -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Alertas Activas</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-semibold text-yellow-600 mb-3">Productos con Stock Bajo</h3>
                        @if($lowStockProducts->isEmpty())
                            <p class="text-sm text-gray-500">No hay productos con stock bajo.</p>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach ($lowStockProducts as $product)
                                    <li class="py-2 flex justify-between">
                                        <span>{{ $product->nombre_del_producto }}</span>
                                        <span class="font-semibold">{{ $product->cantidad_actual }} uds.</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-semibold text-red-600 mb-3">Productos Próximos a Vencer (30 días)</h3>
                         @if($itemsNearExpiration->isEmpty())
                            <p class="text-sm text-gray-500">No hay productos próximos a vencer.</p>
                        @else
                            <ul class="divide-y divide-gray-200">
                                 @foreach ($itemsNearExpiration as $product)
                                    <li class="py-2 flex justify-between">
                                        <span>{{ $product->nombre_del_producto }} (Lote: {{ $product->numero_de_lote }})</span>
                                        <span class="font-semibold">Vence: {{ \Carbon\Carbon::parse($product->fecha_de_vencimiento)->format('d/m/Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
