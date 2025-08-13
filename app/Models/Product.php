<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
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

    // --- MUTATORS PARA CAPITALIZACIÓN AUTOMÁTICA ---
    public function setNombreDelProductoAttribute($value) { $this->attributes['nombre_del_producto'] = Str::title($value); }
    public function setMarcaAttribute($value) { $this->attributes['marca'] = Str::title($value); }
    public function setCategoriaAttribute($value) { $this->attributes['categoria'] = Str::title($value); }
    public function setProveedorAttribute($value) { $this->attributes['proveedor'] = Str::title($value); }

    /**
     * Define la relación: Un Producto tiene muchos Movimientos de Inventario.
     */
    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}
