<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Labventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Editar Elemento</h1>
        <p class="text-gray-600 mb-6">Modifique los detalles del producto en el inventario.</p>

        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
            <form action="{{ route('productos.update', ['producto' => $product->id]) }}" method="POST">
                @csrf @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label for="nombre_del_producto" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Producto</label>
                            <input type="text" name="nombre_del_producto" id="nombre_del_producto" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="{{ old('nombre_del_producto', $product->nombre_del_producto) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                            <select name="categoria" id="categoria" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="">Seleccione una categoría</option>
                                @php
                                    $categorias = ['Reactivos PCR', 'Hematología', 'Química Clínica', 'Hormonas', 'Parasitología', 'Control Calidad', 'Material Laboratorio', 'Pruebas Rápidas', 'Microbiología', 'Coagulación'];
                                @endphp
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria }}" @if(old('categoria', $product->categoria) == $categoria) selected @endif>{{ $categoria }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="presentacion" class="block text-sm font-medium text-gray-700 mb-1">Presentación</label>
                            <input type="text" name="presentacion" id="presentacion" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="{{ old('presentacion', $product->presentacion) }}">
                        </div>
                        <div class="mb-4">
                            <label for="numero_de_lote" class="block text-sm font-medium text-gray-700 mb-1">Número de Lote</label>
                            <input type="text" name="numero_de_lote" id="numero_de_lote" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="{{ old('numero_de_lote', $product->numero_de_lote) }}">
                        </div>
                         <div class="mb-4">
                            <label for="cantidad_actual" class="block text-sm font-medium text-gray-700 mb-1">Cantidad Actual</label>
                            <input type="number" name="cantidad_actual" id="cantidad_actual" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="{{ old('cantidad_actual', $product->cantidad_actual) }}" min="0">
                        </div>
                    </div>

                    <div>
                        <div class="mb-4">
                            <label for="marca" class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                            <select name="marca" id="marca" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="">Seleccione una marca</option>
                                @php
                                    $marcas = ['Abbott', 'Roche', 'Siemens', 'Sysmex'];
                                @endphp
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca }}" @if(old('marca', $product->marca) == $marca) selected @endif>{{ $marca }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="proveedor" class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                            <select name="proveedor" id="proveedor" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="">Seleccione un proveedor</option>
                                @php
                                    $proveedores = ['Abbott', 'Roche', 'Siemens', 'Sysmex'];
                                @endphp
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor }}" @if(old('proveedor', $product->proveedor) == $proveedor) selected @endif>{{ $proveedor }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="fecha_de_vencimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label>
                            <input type="date" name="fecha_de_vencimiento" id="fecha_de_vencimiento" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="{{ old('fecha_de_vencimiento', $product->fecha_de_vencimiento) }}">
                        </div>
                        <div class="mb-4">
                            <label for="costo_unitario" class="block text-sm font-medium text-gray-700 mb-1">Costo Unitario (COP)</label>
                            <input type="number" name="costo_unitario" id="costo_unitario" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="{{ old('costo_unitario', $product->costo_unitario) }}" min="0" step="0.01">
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('productos.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg mr-4 hover:bg-gray-300">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
