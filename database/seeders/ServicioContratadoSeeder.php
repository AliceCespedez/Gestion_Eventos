<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioContratadoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = range(1, 8);      // 8 eventos
        $servicios = range(1, 11);   // 11 servicios

        foreach ($eventos as $evento) {
            foreach ($servicios as $servicio) {

                $cantidad = rand(1, 5);
                $precio_unitario = rand(50, 300);
                $precio_total = $cantidad * $precio_unitario;

                DB::table('servicios_contratados')->insert([
                    'id_evento' => $evento,
                    'id_servicio' => $servicio,
                    'cantidad' => $cantidad,
                    'precio_total' => $precio_total,
                ]);
            }
        }
    }
}