<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editando: {{ $product->nombre_del_producto }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('productos.update', $product->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Columna 1 --}}
                            <div class="space-y-6">
                                <div>
                                    <label for="nombre_del_producto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Producto *</label>
                                    <input type="text" name="nombre_del_producto" id="nombre_del_producto" value="{{ old('nombre_del_producto', $product->nombre_del_producto) }}" required class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                                {{-- INICIO DE LA MODIFICACIÓN --}}
                                <div>
                                    <label for="categoria" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                                    <select name="categoria" id="categoria" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                        <option value="">Seleccione una categoría</option>
                                        <option value="Hematología" {{ old('categoria', $product->categoria) == 'Hematología' ? 'selected' : '' }}>Hematología</option>
                                        <option value="Química Clínica" {{ old('categoria', $product->categoria) == 'Química Clínica' ? 'selected' : '' }}>Química Clínica</option>
                                        <option value="Hormonas" {{ old('categoria', $product->categoria) == 'Hormonas' ? 'selected' : '' }}>Hormonas</option>
                                        <option value="Parasitología" {{ old('categoria', $product->categoria) == 'Parasitología' ? 'selected' : '' }}>Parasitología</option>
                                        <option value="Control Calidad" {{ old('categoria', $product->categoria) == 'Control Calidad' ? 'selected' : '' }}>Control Calidad</option>
                                        <option value="Pruebas Rápidas" {{ old('categoria', $product->categoria) == 'Pruebas Rápidas' ? 'selected' : '' }}>Pruebas Rápidas</option>
                                        <option value="Microbiología" {{ old('categoria', $product->categoria) == 'Microbiología' ? 'selected' : '' }}>Microbiología</option>
                                    </select>
                                </div>
                                {{-- FIN DE LA MODIFICACIÓN --}}

                                @php
                                    $presentacion_tipo = old('presentacion_tipo');
                                    $presentacion_cantidad = old('presentacion_cantidad');
                                    if (empty($presentacion_tipo) && $product->presentacion) {
                                        $parts = explode(' - ', $product->presentacion);
                                        $presentacion_tipo = $parts[0] ?? '';
                                        if (isset($parts[1])) {
                                            $presentacion_cantidad = intval(preg_replace('/[^0-9]/', '', $parts[1]));
                                        }
                                    }
                                @endphp
                                <div>
                                    <label for="presentacion_tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Presentación</label>
                                    <div class="mt-1 flex items-center gap-2">
                                        <select name="presentacion_tipo" id="presentacion_tipo" class="block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                            <option {{ $presentacion_tipo == 'Caja' ? 'selected' : '' }}>Caja</option>
                                            <option {{ $presentacion_tipo == 'Paquete' ? 'selected' : '' }}>Paquete</option>
                                            <option {{ $presentacion_tipo == 'Unidad' ? 'selected' : '' }}>Unidad</option>
                                            <option {{ $presentacion_tipo == 'Kit' ? 'selected' : '' }}>Kit</option>
                                        </select>
                                        <input type="number" name="presentacion_cantidad" value="{{ $presentacion_cantidad }}" placeholder="100" class="block w-1/3 dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                        <span class="text-gray-500 dark:text-gray-400">unidades</span>
                                    </div>
                                </div>

                                <div>
                                    <label for="numero_de_lote" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número de Lote</label>
                                    <input type="text" name="numero_de_lote" id="numero_de_lote" value="{{ old('numero_de_lote', $product->numero_de_lote) }}" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                                <div>
                                    <label for="cantidad_actual" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad Actual (Stock) *</label>
                                    <input type="number" name="cantidad_actual" id="cantidad_actual" value="{{ old('cantidad_actual', $product->cantidad_actual) }}" min="0" required class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                            </div>

                            {{-- Columna 2 --}}
                            <div class="space-y-6">
                                <div>
                                    <label for="marca" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                                    <select name="marca" id="marca" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                        @foreach($marcas as $marca)
                                            <option value="{{ $marca->nombre }}" {{ old('marca', $product->marca) == $marca->nombre ? 'selected' : '' }}>
                                                {{ $marca->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="proveedor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proveedor</label>
                                    <select name="proveedor" id="proveedor" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->nombre }}" {{ old('proveedor', $product->proveedor) == $proveedor->nombre ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    @php
                                        $today = date('Y-m-d');
                                    @endphp
                                    <label for="fecha_de_vencimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Vencimiento</label>
                                    <input type="date" name="fecha_de_vencimiento" id="fecha_de_vencimiento" value="{{ old('fecha_de_vencimiento', $product->fecha_de_vencimiento ? $product->fecha_de_vencimiento->format('Y-m-d') : '') }}" min="{{ $today }}" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                                <div>
                                    <label for="costo_unitario" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Costo Unitario (COP)</label>
                                    <input type="number" name="costo_unitario" id="costo_unitario" value="{{ old('costo_unitario', $product->costo_unitario) }}" min="0" step="0.01" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-4">
                            <a href="{{ route('productos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm">
                                Actualizar Elemento
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>