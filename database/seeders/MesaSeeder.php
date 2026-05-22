<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mesas')->insert([

            // EVENTO 1
            ['id_mesa' => 1, 'id_evento' => 1, 'numero_mesa' => 1, 'capacidad' => 4],
            ['id_mesa' => 2, 'id_evento' => 1, 'numero_mesa' => 2, 'capacidad' => 4],
            ['id_mesa' => 3, 'id_evento' => 1, 'numero_mesa' => 3, 'capacidad' => 4],
            ['id_mesa' => 4, 'id_evento' => 1, 'numero_mesa' => 4, 'capacidad' => 4],

            // EVENTO 2
            ['id_mesa' => 5, 'id_evento' => 2, 'numero_mesa' => 1, 'capacidad' => 4],
            ['id_mesa' => 6, 'id_evento' => 2, 'numero_mesa' => 2, 'capacidad' => 4],
            ['id_mesa' => 7, 'id_evento' => 2, 'numero_mesa' => 3, 'capacidad' => 4],
            ['id_mesa' => 8, 'id_evento' => 2, 'numero_mesa' => 4, 'capacidad' => 4],

            // EVENTO 3
            ['id_mesa' => 9, 'id_evento' => 3, 'numero_mesa' => 1, 'capacidad' => 4],
            ['id_mesa' => 10, 'id_evento' => 3, 'numero_mesa' => 2, 'capacidad' => 4],
            ['id_mesa' => 11, 'id_evento' => 3, 'numero_mesa' => 3, 'capacidad' => 4],
            ['id_mesa' => 12, 'id_evento' => 3, 'numero_mesa' => 4, 'capacidad' => 4],

            // EVENTO 4
            ['id_mesa' => 13, 'id_evento' => 4, 'numero_mesa' => 1, 'capacidad' => 4],
            ['id_mesa' => 14, 'id_evento' => 4, 'numero_mesa' => 2, 'capacidad' => 4],
            ['id_mesa' => 15, 'id_evento' => 4, 'numero_mesa' => 3, 'capacidad' => 4],
            ['id_mesa' => 16, 'id_evento' => 4, 'numero_mesa' => 4, 'capacidad' => 4],

            // EVENTO 5
            ['id_mesa' => 17, 'id_evento' => 5, 'numero_mesa' => 1, 'capacidad' => 4],
            ['id_mesa' => 18, 'id_evento' => 5, 'numero_mesa' => 2, 'capacidad' => 4],
            ['id_mesa' => 19, 'id_evento' => 5, 'numero_mesa' => 3, 'capacidad' => 4],
            ['id_mesa' => 20, 'id_evento' => 5, 'numero_mesa' => 4, 'capacidad' => 4],

            // EVENTO 6
            ['id_mesa' => 21, 'id_evento' => 6, 'numero_mesa' => 1, 'capacidad' => 4],
            ['id_mesa' => 22, 'id_evento' => 6, 'numero_mesa' => 2, 'capacidad' => 4],
            ['id_mesa' => 23, 'id_evento' => 6, 'numero_mesa' => 3, 'capacidad' => 4],
            ['id_mesa' => 24, 'id_evento' => 6, 'numero_mesa' => 4, 'capacidad' => 4],

            // EVENTO 7
            ['id_mesa' => 25, 'id_evento' => 7, 'numero_mesa' => 1, 'capacidad' => 4],
            ['id_mesa' => 26, 'id_evento' => 7, 'numero_mesa' => 2, 'capacidad' => 4],
            ['id_mesa' => 27, 'id_evento' => 7, 'numero_mesa' => 3, 'capacidad' => 4],
            ['id_mesa' => 28, 'id_evento' => 7, 'numero_mesa' => 4, 'capacidad' => 4],

            // EVENTO 8
            ['id_mesa' => 29, 'id_evento' => 8, 'numero_mesa' => 1, 'capacidad' => 4],
            ['id_mesa' => 30, 'id_evento' => 8, 'numero_mesa' => 2, 'capacidad' => 4],
            ['id_mesa' => 31, 'id_evento' => 8, 'numero_mesa' => 3, 'capacidad' => 4],
            ['id_mesa' => 32, 'id_evento' => 8, 'numero_mesa' => 4, 'capacidad' => 4],

        ]);
    }
}