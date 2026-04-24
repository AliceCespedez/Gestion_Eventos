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
        Schema::create('menu', function (Blueprint $table) {
            $table->integer('id_menu', true);
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio_unitario', 10);
            $table->enum('tipo_menu', ['estandar', 'vegetariano', 'vegano', 'sin_gluten', 'sin_lactosa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
