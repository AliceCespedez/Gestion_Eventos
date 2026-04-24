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
        Schema::table('menu_evento', function (Blueprint $table) {
            $table->foreign(['id_evento'], 'fk_evento_menu')->references(['id_evento'])->on('eventos')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_menu'], 'fk_menu_evento')->references(['id_menu'])->on('menu')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_evento', function (Blueprint $table) {
            $table->dropForeign('fk_evento_menu');
            $table->dropForeign('fk_menu_evento');
        });
    }
};
