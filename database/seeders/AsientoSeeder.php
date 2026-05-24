<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsientoSeeder extends Seeder
{
    public function run(): void
    {
        $asientos = [];
        $idAsiento = 1;

        // 32 mesas
        for ($mesa = 1; $mesa <= 32; $mesa++) {

            // 4 asientos por mesa
            for ($numAsiento = 1; $numAsiento <= 4; $numAsiento++) {

                $asientos[] = [
                    'id_asiento' => $idAsiento,
                    'id_mesa' => $mesa,
                    'numero_asiento' => $numAsiento,
                    'id_invitado' => null
                ];

                $idAsiento++;
            }
        }

        DB::table('asiento')->insert($asientos);
    }
}
