<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Este método se ejecuta cuando corremos la migración.
        Schema::table('users', function (Blueprint $table) {
            // Le decimos que añada una columna de tipo string llamada 'role' después de la columna 'email'.
            // Por defecto, cualquier nuevo usuario tendrá el rol de 'operario'.
            $table->string('role')->after('email')->default('operario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Este método se ejecuta si necesitamos deshacer la migración.
        Schema::table('users', function (Blueprint $table) {
            // La instrucción inversa es simplemente eliminar la columna 'role'.
            $table->dropColumn('role');
        });
    }
};