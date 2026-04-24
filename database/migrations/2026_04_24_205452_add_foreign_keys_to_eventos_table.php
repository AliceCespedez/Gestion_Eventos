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
        Schema::table('eventos', function (Blueprint $table) {
            $table->foreign(['id_local'], 'fk_evento_local')->references(['id_local'])->on('locales')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario'], 'fk_evento_usuario')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_tipo'], 'fk_usuario_tipo')->references(['id_tipo'])->on('tipo_evento')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign('fk_evento_local');
            $table->dropForeign('fk_evento_usuario');
            $table->dropForeign('fk_usuario_tipo');
        });
    }
};
