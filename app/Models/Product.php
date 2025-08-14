<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Constante para definir el umbral de stock bajo.
     * Centraliza la regla de negocio en un solo lugar.
     */
    public const LOW_STOCK_THRESHOLD = 10;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_del_producto',
        'marca',
        'categoria',
        'proveedor',
        'presentacion',
        'numero_de_lote',
        'fecha_de_vencimiento',
        'cantidad_actual',
        'costo_unitario',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_de_vencimiento' => 'date',
    ];
}