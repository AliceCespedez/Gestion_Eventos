<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuEventoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = range(1, 8);   // eventos
        $menus = range(1, 9);     // menus

        foreach ($eventos as $evento) {

            // elegir cuántos menus tendrá este evento (2 o 3)
            $cantidadMenus = rand(2, 3);

            // escoger menus aleatorios
            $menusSeleccionados = array_rand(array_flip($menus), $cantidadMenus);

            // si solo devuelve 1 valor, lo convertimos a array
            if (!is_array($menusSeleccionados)) {
                $menusSeleccionados = [$menusSeleccionados];
            }

            foreach ($menusSeleccionados as $menu) {
                DB::table('menu_evento')->insert([
                    'id_evento' => $evento,
                    'id_menu'   => $menu,
                    'cantidad'  => rand(1, 10),
                ]);
            }
        }
    }
}