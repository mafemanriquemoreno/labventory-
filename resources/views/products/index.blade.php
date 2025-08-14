@php
    use App\Models\Product;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Inventario') }}
            </h2>
            <a href="{{ route('productos.create') }}" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
                <i class="fa-solid fa-plus mr-2"></i> Añadir Nuevo Elemento
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Barra de Búsqueda y Filtros --}}
                    <form action="{{ route('productos.index') }}" method="GET" class="mb-4">
                        <div class="flex flex-col md:flex-row items-center gap-4">
                            <div class="flex-grow w-full md:w-auto">
                                <input type="text" name="search" placeholder="🔎 Buscar por nombre, lote, marca..." class="w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700" value="{{ $filters['search'] ?? '' }}">
                            </div>
                            <select name="category" class="w-full md:w-auto dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                <option value="">Todas las Categorías</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ ($filters['category'] ?? '') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="w-full md:w-auto dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                <option value="">Todos los Estados</option>
                                <option value="normal" {{ ($filters['status'] ?? '') == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="stock_bajo" {{ ($filters['status'] ?? '') == 'stock_bajo' ? 'selected' : '' }}>Stock Bajo</option>
                                <option value="agotado" {{ ($filters['status'] ?? '') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                            </select>
                            <button type="submit" class="w-full md:w-auto bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm">Filtrar</button>
                            <a href="{{ route('productos.index') }}" class="w-full md:w-auto text-center bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm">Limpiar</a>
                        </div>
                    </form>

                    {{-- Contenedor para los filtros activos --}}
                    @if(collect($filters)->filter()->isNotEmpty())
                    <div class="mb-6 flex flex-wrap items-center gap-2">
                        <span class="text-sm font-semibold">Filtros Activos:</span>
                        @foreach($filters as $key => $value)
                            @if(!empty($value))
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                    {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}
                                    <a href="{{ route('productos.index', array_merge(request()->except($key), ['page' => 1])) }}" class="ms-2 text-blue-600 hover:text-blue-800">
                                        <i class="fa-solid fa-times-circle"></i>
                                    </a>
                                </span>
                            @endif
                        @endforeach
                    </div>
                    @endif


                    {{-- Tabla de Productos --}}
                    <div class="overflow-x-auto">
                        @php
                            function sortable_link($column, $label, $currentSortBy, $currentSortDirection) {
                                $direction = ($currentSortBy == $column && $currentSortDirection == 'asc') ? 'desc' : 'asc';
                                $url = route('productos.index', array_merge(request()->query(), ['sort_by' => $column, 'sort_direction' => $direction]));
                                $icon = '';
                                if ($currentSortBy == $column) {
                                    $icon = $currentSortDirection == 'asc' ? '<i class="fa-solid fa-arrow-up-short-wide ms-1"></i>' : '<i class="fa-solid fa-arrow-down-wide-short ms-1"></i>';
                                }
                                return '<a href="' . $url . '" class="flex items-center">' . $label . $icon . '</a>';
                            }
                        @endphp

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">{!! sortable_link('nombre_del_producto', 'Elemento', $sortBy, $sortDirection) !!}</th>
                                    <th scope="col" class="px-6 py-3">{!! sortable_link('proveedor', 'Proveedor', $sortBy, $sortDirection) !!}</th>
                                    <th scope="col" class="px-6 py-3">{!! sortable_link('categoria', 'Categoría', $sortBy, $sortDirection) !!}</th>
                                    <th scope="col" class="px-6 py-3">{!! sortable_link('cantidad_actual', 'Stock', $sortBy, $sortDirection) !!}</th>
                                    <th scope="col" class="px-6 py-3">Lote</th>
                                    <th scope="col" class="px-6 py-3">{!! sortable_link('fecha_de_vencimiento', 'Vencimiento', $sortBy, $sortDirection) !!}</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $product->nombre_del_producto }}</td>
                                    <td class="px-6 py-4">{{ $product->proveedor }}</td>
                                    <td class="px-6 py-4">{{ $product->categoria }}</td>
                                    <td class="px-6 py-4 font-bold {{ $product->cantidad_actual == 0 ? 'text-red-500' : ($product->cantidad_actual < Product::LOW_STOCK_THRESHOLD ? 'text-orange-400' : '') }}">
                                        {{ $product->cantidad_actual }}
                                    </td>
                                    <td class="px-6 py-4">{{ $product->numero_de_lote }}</td>
                                    <td class="px-6 py-4">
                                        @if($product->fecha_de_vencimiento)
                                            {{ \Carbon\Carbon::parse($product->fecha_de_vencimiento)->format('d/m/Y') }}
                                        @else
                                            <span class="text-gray-500">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($product->cantidad_actual == 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Agotado</span>
                                        @elseif($product->cantidad_actual < Product::LOW_STOCK_THRESHOLD)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Stock Bajo</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Normal</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex gap-2" x-data>
                                        <a href="{{ route('productos.edit', $product->id) }}"><i class="fa-solid fa-pencil text-blue-500 hover:text-blue-700"></i></a>
                                        <a href="{{ route('productos.showDischargeForm', $product->id) }}"><i class="fa-solid fa-arrow-down-wide-short text-green-500 hover:text-green-700"></i></a>
                                        
                                        {{--
                                            INICIO DE LA MODIFICACIÓN
                                            Envolvemos todo el formulario de eliminación en la directiva @can.
                                            Este bloque solo se mostrará si el Gate 'esAdmin' devuelve true.
                                        --}}
                                        @can('esAdmin')
                                        <form x-ref="deleteForm{{ $product->id }}" action="{{ route('productos.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="
                                                Swal.fire({
                                                    title: '¿Estás seguro?',
                                                    text: `¡No podrás revertir esto! Se eliminará el producto '{{ $product->nombre_del_producto }}'.`,
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: '¡Sí, eliminar!',
                                                    cancelButtonText: 'Cancelar',
                                                    background: '#1f2937',
                                                    color: '#f3f4f6',
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $refs.deleteForm{{ $product->id }}.submit();
                                                    }
                                                })
                                            ">
                                                <i class="fa-solid fa-trash-can text-red-500 hover:text-red-700"></i>
                                            </button>
                                        </form>
                                        @endcan
                                        {{-- FIN DE LA MODIFICACIÓN --}}

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>