<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- 1. IMPORTAMOS LA CLASE DE RELACIÓN

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
        'user_id', // <-- 2. AÑADIMOS user_id A LA LISTA
    ];

    /**
     * INICIO DE LA MODIFICACIÓN:
     * Define la relación con el modelo User.
     * Un movimiento "pertenece a" un usuario.
     * Esto nos permitirá hacer $movimiento->user->name para obtener el nombre del responsable.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * FIN DE LA MODIFICACIÓN
     */


    /**
     * Define la relación con el modelo Product.
     * Un movimiento "pertenece a" un producto.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}