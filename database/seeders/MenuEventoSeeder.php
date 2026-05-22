<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuEventoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = range(1, 8);   // IDs de eventos
        $menus = range(1, 9);    // IDs de menus

        foreach ($eventos as $evento) {
            foreach ($menus as $menu) {

                DB::table('menu_evento')->insert([
                    'id_evento' => $evento,
                    'id_menu'   => $menu,
                    'cantidad'  => rand(1, 10),
                ]);
            }
        }
    }
}