<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Producto - Labventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Incluimos Alpine.js para la interactividad -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Agregar Nuevo Elemento</h1>

        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
            <form action="{{ route('productos.store') }}" method="POST">
                @csrf <!-- Directiva de seguridad OBLIGATORIA en Laravel -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Columna Izquierda -->
                    <div>
                        <div class="mb-4">
                            <label for="nombre_del_producto" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Producto</label>
                            <input type="text" name="nombre_del_producto" id="nombre_del_producto" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ej: Reactivo de Glucosa" required>
                        </div>

                        <div class="mb-4">
                            <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                            <select name="categoria" id="categoria" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="" disabled selected>Seleccione una categoría</option>
                                <option value="Reactivos PCR">Reactivos PCR</option>
                                <option value="Hematología">Hematología</option>
                                <option value="Química Clínica">Química Clínica</option>
                                <option value="Hormonas">Hormonas</option>
                                <option value="Parasitología">Parasitología</option>
                                <option value="Control Calidad">Control Calidad</option>
                                <option value="Material Laboratorio">Material Laboratorio</option>
                                <option value="Pruebas Rápidas">Pruebas Rápidas</option>
                                <option value="Microbiología">Microbiología</option>
                                <option value="Coagulación">Coagulación</option>
                                <option value="_create_new_">--- Crear nueva categoría ---</option>
                            </select>
                        </div>

                        <!-- Campo Compuesto para Presentación con Alpine.js -->
                        <div class="mb-4" x-data="{ tipo: 'Caja', cantidad: 100, get valorFinal() { return `${this.tipo} x ${this.cantidad} unidades` } }">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Presentación</label>
                            <div class="flex items-center space-x-2">
                                <select x-model="tipo" class="w-1/3 px-3 py-2 border border-gray-300 rounded-lg">
                                    <option value="Caja">Caja</option>
                                    <option value="Paquete">Paquete</option>
                                </select>
                                <input type="number" x-model.number="cantidad" class="w-1/3 px-3 py-2 border border-gray-300 rounded-lg" min="1">
                                <span class="text-gray-500 w-1/3">unidades</span>
                                <button type="button" class="bg-gray-200 px-3 py-2 rounded-lg text-sm hover:bg-gray-300">+</button>
                            </div>
                            <input type="hidden" name="presentacion" :value="valorFinal">
                        </div>

                        <div class="mb-4">
                            <label for="numero_de_lote" class="block text-sm font-medium text-gray-700 mb-1">Número de Lote</label>
                            <input type="text" name="numero_de_lote" id="numero_de_lote" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ej: L202401">
                        </div>
                         <div class="mb-4">
                            <label for="cantidad_actual" class="block text-sm font-medium text-gray-700 mb-1">Cantidad Actual (Stock)</label>
                            <input type="number" name="cantidad_actual" id="cantidad_actual" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="1" min="0">
                        </div>
                    </div>

                    <!-- Columna Derecha -->
                    <div>
                        <div class="mb-4">
                            <label for="marca" class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                            <select name="marca" id="marca" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="" disabled selected>Seleccione una marca</option>
                                <option value="Abbott">Abbott</option>
                                <option value="Roche">Roche</option>
                                <option value="Siemens">Siemens</option>
                                <option value="Sysmex">Sysmex</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="proveedor" class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                             <select name="proveedor" id="proveedor" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="" disabled selected>Seleccione un proveedor</option>
                                <option value="Abbott">Abbott</option>
                                <option value="Roche">Roche</option>
                                <option value="Siemens">Siemens</option>
                                <option value="Sysmex">Sysmex</option>
                                <option value="_create_new_">--- Crear nuevo proveedor ---</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="fecha_de_vencimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label>
                            <input type="date" name="fecha_de_vencimiento" id="fecha_de_vencimiento" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="costo_unitario" class="block text-sm font-medium text-gray-700 mb-1">Costo Unitario (COP)</label>
                            <input type="number" name="costo_unitario" id="costo_unitario" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="0" min="0" step="0.01">
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('productos.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg mr-4 hover:bg-gray-300">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Agregar Elemento
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
