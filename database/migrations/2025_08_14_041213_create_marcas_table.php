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
        // Define la estructura de la nueva tabla 'marcas'
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // El nombre de la marca debe ser único
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marcas');
    }
};