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
        Schema::table('servicios_contratados', function (Blueprint $table) {
            $table->foreign(['id_servicio'], 'fk_servicio_evento')->references(['id_servicio'])->on('servicios')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_evento'], 'servicios_contratados_ibfk_1')->references(['id_evento'])->on('eventos')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios_contratados', function (Blueprint $table) {
            $table->dropForeign('fk_servicio_evento');
            $table->dropForeign('servicios_contratados_ibfk_1');
        });
    }
};
