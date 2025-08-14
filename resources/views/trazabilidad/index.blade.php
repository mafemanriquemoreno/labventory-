<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trazabilidad de Inventario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- INICIO DE LA MODIFICACIÓN: Formulario de Filtros --}}
                    <form action="{{ route('trazabilidad.index') }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                            {{-- Filtro por Producto --}}
                            <div class="col-span-1 md:col-span-2">
                                <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Producto</label>
                                <select name="product_id" id="product_id" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                    <option value="">Todos los Productos</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ ($filters['product_id'] ?? '') == $product->id ? 'selected' : '' }}>
                                            {{ $product->nombre_del_producto }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Filtro por Tipo de Movimiento --}}
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                                <select name="type" id="type" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                    <option value="">Todos los Tipos</option>
                                     @foreach($movementTypes as $type)
                                        <option value="{{ $type }}" {{ ($filters['type'] ?? '') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filtro por Rango de Fechas --}}
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Desde</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $filters['start_date'] ?? '' }}" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hasta</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $filters['end_date'] ?? '' }}" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                            </div>
                        </div>
                        <div class="flex justify-end gap-4 mt-4">
                            <a href="{{ route('trazabilidad.index') }}" class="w-full sm:w-auto text-center bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm">Limpiar</a>
                            <button type="submit" class="w-full sm:w-auto bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm">Filtrar</button>
                        </div>
                    </form>
                    {{-- FIN DE LA MODIFICACIÓN --}}


                    {{-- Tabla de Movimientos --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Fecha y Hora</th>
                                    <th scope="col" class="px-6 py-3">Producto Afectado</th>
                                    <th scope="col" class="px-6 py-3">Tipo de Movimiento</th>
                                    <th scope="col" class="px-6 py-3">Cantidad</th>
                                    <th scope="col" class="px-6 py-3">Responsable</th>
                                    <th scope="col" class="px-6 py-3">Notas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($movements as $movement)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($movement->created_at)->format('d/m/Y H:i:s') }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $movement->product->nombre_del_producto ?? 'Producto no encontrado' }}</td>
                                    <td class="px-6 py-4">
                                        @if($movement->type == 'salida')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Salida</span>
                                        @elseif($movement->type == 'eliminado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Eliminado</span>
                                        @elseif($movement->type == 'entrada')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Entrada</span>
                                        @elseif($movement->type == 'actualizacion')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Actualización</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($movement->type) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold @if(in_array($movement->type, ['salida', 'eliminado'])) text-red-500 @elseif($movement->type == 'entrada') text-green-500 @endif">
                                        @if(in_array($movement->type, ['salida', 'eliminado'])) -{{ $movement->quantity }}
                                        @elseif($movement->type == 'entrada') +{{ $movement->quantity }}
                                        @else {{ $movement->quantity }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $movement->user?->name ?? 'Sistema' }}</td>
                                    <td class="px-6 py-4">{{ $movement->notes }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No se encontraron movimientos con los filtros aplicados.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{-- INICIO DE LA MODIFICACIÓN: Hacemos que la paginación recuerde los filtros --}}
                        {{ $movements->appends($filters)->links() }}
                        {{-- FIN DE LA MODIFICACIÓN --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>