<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'notes',
    ];

    /**
     * Define la relación: Un Movimiento de Inventario pertenece a un Producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
