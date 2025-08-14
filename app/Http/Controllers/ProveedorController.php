<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Guarda un nuevo proveedor en la base de datos y lo devuelve como JSON.
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos. El nombre es obligatorio y no puede repetirse.
        $validated = $request->validate([
            'nombre' => 'required|string|unique:proveedores|max:255',
        ]);

        // 2. Creamos el nuevo proveedor.
        $proveedor = Proveedor::create([
            'nombre' => $validated['nombre'],
        ]);

        // 3. Devolvemos una respuesta JSON con el nuevo proveedor.
        // Esto es crucial para que el frontend pueda actualizar el desplegable.
        return response()->json($proveedor);
    }
}