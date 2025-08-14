<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agregar Reactivo / Equipo al Inventario') }}
        </h2>
    </x-slot>

    <div class="py-12"
         x-data="{
            modalProveedorOpen: false,
            newProviderName: '',
            providerSaving: false,
            providerError: '',

            modalMarcaOpen: false,
            newMarcaName: '',
            marcaSaving: false,
            marcaError: '',

            saveProvider() {
                this.providerSaving = true;
                this.providerError = '';

                fetch('{{ route('proveedores.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ nombre: this.newProviderName })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => Promise.reject(data));
                    }
                    return response.json();
                })
                .then(newProvider => {
                    const select = document.getElementById('proveedor');
                    const newOption = new Option(newProvider.nombre, newProvider.nombre, true, true);
                    select.add(newOption);
                    
                    this.modalProveedorOpen = false;
                    this.newProviderName = '';
                })
                .catch(error => {
                    if (error.errors && error.errors.nombre) {
                        this.providerError = error.errors.nombre[0];
                    } else {
                        this.providerError = 'Ocurrió un error al guardar.';
                    }
                })
                .finally(() => {
                    this.providerSaving = false;
                });
            },

            saveMarca() {
                this.marcaSaving = true;
                this.marcaError = '';

                fetch('{{ route('marcas.store') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content') },
                    body: JSON.stringify({ nombre: this.newMarcaName })
                })
                .then(response => {
                    if (!response.ok) { return response.json().then(data => Promise.reject(data)); }
                    return response.json();
                })
                .then(newMarca => {
                    const select = document.getElementById('marca');
                    const newOption = new Option(newMarca.nombre, newMarca.nombre, true, true);
                    select.add(newOption);
                    
                    this.modalMarcaOpen = false;
                    this.newMarcaName = '';
                })
                .catch(error => {
                    if (error.errors && error.errors.nombre) { this.marcaError = error.errors.nombre[0]; } 
                    else { this.marcaError = 'Ocurrió un error al guardar.'; }
                })
                .finally(() => { this.marcaSaving = false; });
            }
         }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('productos.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Columna 1 --}}
                            <div class="space-y-6">
                                <div>
                                    <label for="nombre_del_producto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Producto *</label>
                                    <input type="text" name="nombre_del_producto" id="nombre_del_producto" placeholder="Ej: Reactivo de Glucosa" required class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                                {{-- INICIO DE LA MODIFICACIÓN --}}
                                <div>
                                    <label for="categoria" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                                    <select name="categoria" id="categoria" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                        <option value="">Seleccione una categoría</option>
                                        <option value="Hematología">Hematología</option>
                                        <option value="Química Clínica">Química Clínica</option>
                                        <option value="Hormonas">Hormonas</option>
                                        <option value="Parasitología">Parasitología</option>
                                        <option value="Control Calidad">Control Calidad</option>
                                        <option value="Pruebas Rápidas">Pruebas Rápidas</option>
                                        <option value="Microbiología">Microbiología</option>
                                    </select>
                                </div>
                                {{-- FIN DE LA MODIFICACIÓN --}}
                                <div>
                                    <label for="presentacion_tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Presentación</label>
                                    <div class="mt-1 flex items-center gap-2">
                                        <select name="presentacion_tipo" id="presentacion_tipo" class="block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                            <option>Caja</option> <option>Paquete</option> <option>Unidad</option> <option>Kit</option>
                                        </select>
                                        <input type="number" name="presentacion_cantidad" placeholder="100" class="block w-1/3 dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                        <span class="text-gray-500 dark:text-gray-400">unidades</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="numero_de_lote" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número de Lote</label>
                                    <input type="text" name="numero_de_lote" id="numero_de_lote" placeholder="Ej: L202401" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                                <div>
                                    <label for="cantidad_actual" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad Actual (Stock) *</label>
                                    <input type="number" name="cantidad_actual" id="cantidad_actual" value="1" min="0" required class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                            </div>

                            {{-- Columna 2 --}}
                            <div class="space-y-6">
                                <div>
                                    <label for="marca" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                                    <select name="marca" id="marca" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700"
                                            @change="if ($event.target.value === 'add_new_marca') { modalMarcaOpen = true; $event.target.value = ''; }">
                                        <option value="">Seleccione una marca</option>
                                        @foreach($marcas as $marca)
                                            <option value="{{ $marca->nombre }}" {{ old('marca') == $marca->nombre ? 'selected' : '' }}>
                                                {{ $marca->nombre }}
                                            </option>
                                        @endforeach
                                        @can('esAdmin')
                                            <option value="add_new_marca" class="text-cyan-500 font-bold">--- Agregar Nueva Marca ---</option>
                                        @endcan
                                    </select>
                                </div>
                                <div>
                                    <label for="proveedor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proveedor</label>
                                    <select name="proveedor" id="proveedor" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700"
                                            @change="if ($event.target.value === 'add_new_proveedor') { modalProveedorOpen = true; $event.target.value = ''; }">
                                        <option value="">Seleccione un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->nombre }}" {{ old('proveedor') == $proveedor->nombre ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                        @can('esAdmin')
                                            <option value="add_new_proveedor" class="text-cyan-500 font-bold">--- Agregar Nuevo Proveedor ---</option>
                                        @endcan
                                    </select>
                                </div>
                                <div>
                                    @php $today = date('Y-m-d'); @endphp
                                    <label for="fecha_de_vencimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Vencimiento</label>
                                    <input type="date" name="fecha_de_vencimiento" id="fecha_de_vencimiento" min="{{ $today }}" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                                <div>
                                    <label for="costo_unitario" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Costo Unitario (COP)</label>
                                    <input type="number" name="costo_unitario" id="costo_unitario" placeholder="0" min="0" step="0.01" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-4">
                            <a href="{{ route('productos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm">Cancelar</a>
                            <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm">Agregar Elemento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="modalProveedorOpen" @keydown.escape.window="modalProveedorOpen = false" x-transition class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
            <div @click.away="modalProveedorOpen = false" class="bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-2xl p-6 w-full max-w-md border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">Agregar Nuevo Proveedor</h3>
                <div>
                    <label for="new_proveedor_name" class="block text-sm font-medium text-gray-300">Nombre del Proveedor</label>
                    <input type="text" id="new_proveedor_name" x-model="newProviderName" @keydown.enter.prevent="saveProvider()" class="mt-1 block w-full bg-gray-900/50 border-gray-600 text-white rounded-md shadow-sm">
                    <p x-show="providerError" x-text="providerError" class="text-sm text-red-500 mt-1"></p>
                </div>
                <div class="mt-6 flex justify-end gap-4">
                    <button @click="modalProveedorOpen = false" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">Cancelar</button>
                    <button @click="saveProvider()" :disabled="providerSaving" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        <span x-show="!providerSaving">Guardar</span>
                        <span x-show="providerSaving">Guardando...</span>
                    </button>
                </div>
            </div>
        </div>
        
        <div x-show="modalMarcaOpen" @keydown.escape.window="modalMarcaOpen = false" x-transition class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
            <div @click.away="modalMarcaOpen = false" class="bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-2xl p-6 w-full max-w-md border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">Agregar Nueva Marca</h3>
                <div>
                    <label for="new_marca_name" class="block text-sm font-medium text-gray-300">Nombre de la Marca</label>
                    <input type="text" id="new_marca_name" x-model="newMarcaName" @keydown.enter.prevent="saveMarca()" class="mt-1 block w-full bg-gray-900/50 border-gray-600 text-white rounded-md shadow-sm">
                    <p x-show="marcaError" x-text="marcaError" class="text-sm text-red-500 mt-1"></p>
                </div>
                <div class="mt-6 flex justify-end gap-4">
                    <button @click="modalMarcaOpen = false" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">Cancelar</button>
                    <button @click="saveMarca()" :disabled="marcaSaving" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        <span x-show="!marcaSaving">Guardar</span>
                        <span x-show="marcaSaving">Guardando...</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>