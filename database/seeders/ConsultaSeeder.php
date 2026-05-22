<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConsultaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultas')->insert([
            'id_consulta' => 1,
            'id_usuario' => 1,
            'asunto' => 'Consulta sobre evento',
            'mensaje' => 'Quisiera saber más información sobre la disponibilidad del evento y los servicios incluidos.',
            'tipo_consulta' => 'información',
            'prioridad' => 'alta',
            'leido' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}