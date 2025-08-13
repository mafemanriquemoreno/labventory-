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
        Schema::table('inventory_movements', function (Blueprint $table) {
            // 1. Primero, eliminamos la regla antigua ('cascade')
            $table->dropForeign(['product_id']);

            // 2. HACEMOS LA COLUMNA NULLABLE (Este es el cambio)
            $table->foreignId('product_id')->nullable()->change();

            // 3. Añadimos la nueva regla ('set null')
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            // Esto revierte los cambios si es necesario
            $table->dropForeign(['product_id']);
            
            $table->foreignId('product_id')->nullable(false)->change();

            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
        });
    }
};
