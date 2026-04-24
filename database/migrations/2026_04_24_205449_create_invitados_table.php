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
        Schema::create('invitados', function (Blueprint $table) {
            $table->integer('id_invitado', true);
            $table->string('nombre');
            $table->string('email');
            $table->enum('confirmacion', ['pendiente', 'confirmado', 'rechazado']);
            $table->integer('id_evento')->nullable()->index('fk_invitados_evento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitados');
    }
};
