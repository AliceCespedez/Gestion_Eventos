<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioContratadoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = DB::table('eventos')->get();

        $servicios = range(1, 11);

        foreach ($eventos as $evento) {

            $presupuestoRestante = $evento->presupuesto;

            // mezclar servicios
            $serviciosSeleccionados = collect($servicios)->shuffle();

            foreach ($serviciosSeleccionados as $servicio) {

                if ($presupuestoRestante <= 0) {
                    break;
                }

                $cantidad = rand(1, 5);
                $precio_unitario = rand(50, 300);
                $precio_total = $cantidad * $precio_unitario;

                // si se pasa del presupuesto, ajustamos
                if ($precio_total > $presupuestoRestante) {

                    // recalcular cantidad máxima posible
                    $maxCantidad = floor($presupuestoRestante / $precio_unitario);

                    if ($maxCantidad <= 0) {
                        continue;
                    }

                    $cantidad = rand(1, $maxCantidad);
                    $precio_total = $cantidad * $precio_unitario;
                }

                DB::table('servicios_contratados')->insert([
                    'id_evento' => $evento->id_evento,
                    'id_servicio' => $servicio,
                    'cantidad' => $cantidad,
                    'precio_total' => $precio_total,
                ]);

                $presupuestoRestante -= $precio_total;
            }
        }
    }
}
