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
        Schema::create('menu_evento', function (Blueprint $table) {
            $table->integer('id_evento');
            $table->integer('id_menu')->index('fk_menu_evento');
            $table->integer('cantidad');

            $table->primary(['id_evento', 'id_menu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_evento');
    }
};
