<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
           UsuarioSeeder::class,
            TipoEventoSeeder::class,
            LocalSeeder::class,
            MenuSeeder::class,
            ServicioSeeder::class,
            EventoSeeder::class,
            InvitadoSeeder::class,
            MesaSeeder::class,
            AsientoSeeder::class,
            ServicioContratadoSeeder::class,
            MenuEventoSeeder::class,
            ConsultaSeeder::class,
        ]);
    }
}