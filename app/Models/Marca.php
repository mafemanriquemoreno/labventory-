<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    /**
     * Le decimos a Laravel el nombre correcto de la tabla.
     */
    protected $table = 'marcas';

    /**
     * Permitimos que el campo 'nombre' sea llenado masivamente.
     */
    protected $fillable = [
        'nombre',
    ];
}