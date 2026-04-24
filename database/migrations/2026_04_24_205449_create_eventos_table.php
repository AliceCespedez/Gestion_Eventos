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
        Schema::create('eventos', function (Blueprint $table) {
            $table->integer('id_evento', true);
            $table->integer('id_usuario')->index('fk_evento_usuario');
            $table->integer('id_local')->index('fk_evento_local');
            $table->integer('id_tipo')->index('fk_usuario_tipo');
            $table->string('nombre_evento');
            $table->date('fecha');
            $table->decimal('presupuesto', 10);
            $table->enum('estado', ['pendiente', 'confirmado', 'cancelado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
