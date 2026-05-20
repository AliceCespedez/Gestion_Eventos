<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TipoEventoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipo_evento')->insert([
            ['id_tipo' => 1, 'nombre_tipo' => 'Cumpleaños'],
            ['id_tipo' => 2, 'nombre_tipo' => 'Boda'],
            ['id_tipo' => 3, 'nombre_tipo' => 'Cocktail'],
            ['id_tipo' => 4, 'nombre_tipo' => 'Coffee Break'],
            ['id_tipo' => 5, 'nombre_tipo' => 'Corporativo'],
        ]);
    }
}
