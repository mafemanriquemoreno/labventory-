<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_del_producto');
            $table->string('marca')->nullable();
            $table->string('categoria')->nullable();
            $table->string('proveedor')->nullable();
            $table->string('presentacion')->nullable();
            $table->string('numero_de_lote')->nullable();
            $table->date('fecha_de_vencimiento')->nullable();
            $table->integer('cantidad_actual')->default(0);
            $table->decimal('costo_unitario', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
