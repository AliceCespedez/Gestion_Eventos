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

            ['id_tipo' => 1,  'nombre_tipo' => 'Cumpleaños'],
            ['id_tipo' => 2,  'nombre_tipo' => 'Boda'],
            ['id_tipo' => 3,  'nombre_tipo' => 'Cocktail'],
            ['id_tipo' => 4,  'nombre_tipo' => 'Coffee Break'],
            ['id_tipo' => 5,  'nombre_tipo' => 'Corporativo'],
            ['id_tipo' => 6,  'nombre_tipo' => 'Comunión'],
            ['id_tipo' => 7,  'nombre_tipo' => 'Bautizo'],
            ['id_tipo' => 8,  'nombre_tipo' => 'Graduación'],
            ['id_tipo' => 9,  'nombre_tipo' => 'Fiesta Temática'],
            ['id_tipo' => 10, 'nombre_tipo' => 'Cena de Empresa'],
            ['id_tipo' => 11, 'nombre_tipo' => 'Conferencia'],
            ['id_tipo' => 12, 'nombre_tipo' => 'Baby Shower'],
            ['id_tipo' => 13, 'nombre_tipo' => 'Despedida de Soltero/a'],
            ['id_tipo' => 14, 'nombre_tipo' => 'Gala Benéfica'],
            ['id_tipo' => 15, 'nombre_tipo' => 'Cena Privada'],
            ['id_tipo' => 16, 'nombre_tipo' => 'Evento Deportivo'],

        ]);
    }
}
