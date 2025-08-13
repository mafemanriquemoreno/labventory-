<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descargar Stock - Labventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-2">Descargar Stock</h1>
        <p class="text-gray-600 mb-6">Registrar una salida del inventario para el producto: <strong class="font-semibold">{{ $product->nombre_del_producto }}</strong></p>

        {{-- Mostramos errores de validación si existen --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6 max-w-lg mx-auto">
            <form action="{{ route('productos.dischargeStock', $product->id) }}" method="POST">
                @csrf <div class="mb-4">
                    <p class="text-sm text-gray-600">Stock Actual:</p>
                    <p class="text-2xl font-bold">{{ $product->cantidad_actual }} unidades</p>
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Cantidad a Descargar</label>
                    <input type="number" name="quantity" id="quantity" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="1" min="1" max="{{ $product->cantidad_actual }}" required>
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notas (Opcional)</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ej: Uso para control de calidad"></textarea>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('productos.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg mr-4 hover:bg-gray-300">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        Registrar Salida
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
