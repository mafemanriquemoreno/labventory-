<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Guarda una nueva marca en la base de datos y la devuelve como JSON.
     */
    public function store(Request $request)
    {
        // 1. Validamos que el nombre no esté vacío y no se repita en la tabla 'marcas'.
        $validated = $request->validate([
            'nombre' => 'required|string|unique:marcas|max:255',
        ]);

        // 2. Creamos la nueva marca.
        $marca = Marca::create([
            'nombre' => $validated['nombre'],
        ]);

        // 3. Devolvemos una respuesta JSON con la nueva marca.
        return response()->json($marca);
    }
}