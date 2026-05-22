<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('eventos')->insert([

            [
                'id_evento' => 1,
                'id_usuario' => 7,
                'id_local' => 1,
                'id_tipo' => 2,
                'nombre_evento' => 'Boda de Carlos y Laura',
                'fecha' => '2026-06-15',
                'presupuesto' => 12000.00,
                'estado' => 'pendiente'
            ],

            [
                'id_evento' => 2,
                'id_usuario' => 8,
                'id_local' => 2,
                'id_tipo' => 1,
                'nombre_evento' => 'Cumpleaños de Lucía',
                'fecha' => '2026-07-10',
                'presupuesto' => 2500.00,
                'estado' => 'confirmado'
            ],

            [
                'id_evento' => 3,
                'id_usuario' => 9,
                'id_local' => 3,
                'id_tipo' => 5,
                'nombre_evento' => 'Cena Corporativa TechCorp',
                'fecha' => '2026-09-01',
                'presupuesto' => 8000.00,
                'estado' => 'pendiente'
            ],

            [
                'id_evento' => 4,
                'id_usuario' => 10,
                'id_local' => 1,
                'id_tipo' => 6,
                'nombre_evento' => 'Comunión de Pablo',
                'fecha' => '2026-05-20',
                'presupuesto' => 3500.00,
                'estado' => 'confirmado'
            ],

            [
                'id_evento' => 5,
                'id_usuario' => 11,
                'id_local' => 4,
                'id_tipo' => 12,
                'nombre_evento' => 'Baby Shower Andrea',
                'fecha' => '2026-08-12',
                'presupuesto' => 1800.00,
                'estado' => 'pendiente'
            ],

            [
                'id_evento' => 6,
                'id_usuario' => 3,
                'id_local' => 2,
                'id_tipo' => 9,
                'nombre_evento' => 'Fiesta Neon Party',
                'fecha' => '2026-10-31',
                'presupuesto' => 4200.00,
                'estado' => 'confirmado'
            ],

            [
                'id_evento' => 7,
                'id_usuario' => 12,
                'id_local' => 5,
                'id_tipo' => 10,
                'nombre_evento' => 'Cena Empresa Nova',
                'fecha' => '2026-11-18',
                'presupuesto' => 9500.00,
                'estado' => 'pendiente'
            ],

            [
                'id_evento' => 8,
                'id_usuario' => 10,
                'id_local' => 3,
                'id_tipo' => 3,
                'nombre_evento' => 'Cocktail Verano',
                'fecha' => '2026-07-25',
                'presupuesto' => 5000.00,
                'estado' => 'confirmado'
            ],

        ]);
    }
}