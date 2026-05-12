<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {

            $table->id('id_consulta');

            $table->integer('id_usuario');

            $table->string('asunto');

            $table->text('mensaje');

            $table->string('tipo_consulta');

            $table->string('prioridad')->default('media');

            $table->boolean('leido')->default(false);

            $table->timestamps();

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('usuarios')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};