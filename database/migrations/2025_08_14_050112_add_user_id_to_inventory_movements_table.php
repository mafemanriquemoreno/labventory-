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
            // Añadimos la columna para guardar el ID del usuario responsable.
            // La hacemos 'nullable' por si en el futuro hay movimientos automáticos del sistema.
            // 'constrained' crea la relación (foreign key) con la tabla 'users'.
            $table->foreignId('user_id')->nullable()->after('product_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            // La instrucción inversa es eliminar la relación y luego la columna.
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};