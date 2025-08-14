<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    /**
     * INICIO DE LA MODIFICACIÓN
     * El nombre de la tabla asociada con el modelo.
     * Le decimos a Laravel explícitamente que este modelo
     * debe usar la tabla 'proveedores'.
     *
     * @var string
     */
    protected $table = 'proveedores';
    /**
     * FIN DE LA MODIFICACIÓN
     */


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
    ];
}