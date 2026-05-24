<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuEventoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = DB::table('eventos')->get();
        $menus = DB::table('menu')->get();

        foreach ($eventos as $evento) {

            $presupuestoRestante = $evento->presupuesto;

            // mezclar menús aleatoriamente
            $menusMezclados = $menus->shuffle();

            foreach ($menusMezclados as $menu) {

                if ($presupuestoRestante <= 0) {
                    break;
                }

                // intentamos una cantidad aleatoria
                $cantidad = rand(1, 5);

                $costeTotal = $menu->precio_unitario * $cantidad;

                // si se pasa del presupuesto, probamos ajustar
                if ($costeTotal > $presupuestoRestante) {

                    // recalcular cantidad máxima posible
                    $maxCantidad = floor($presupuestoRestante / $menu->precio_unitario);

                    if ($maxCantidad <= 0) {
                        continue;
                    }

                    $cantidad = rand(1, $maxCantidad);
                    $costeTotal = $menu->precio_unitario   * $cantidad;
                }

                DB::table('menu_evento')->insert([
                    'id_evento' => $evento->id_evento,
                    'id_menu'   => $menu->id_menu,
                    'cantidad'  => $cantidad,
                ]);

                $presupuestoRestante -= $costeTotal;
            }
        }
    }
}
