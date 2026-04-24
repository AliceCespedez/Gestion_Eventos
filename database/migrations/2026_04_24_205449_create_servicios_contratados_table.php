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
        Schema::create('servicios_contratados', function (Blueprint $table) {
            $table->integer('id_contratacion', true);
            $table->integer('id_evento')->index('id_evento');
            $table->integer('id_servicio')->index('fk_servicio_evento');
            $table->integer('cantidad');
            $table->decimal('precio_total', 10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_contratados');
    }
};
