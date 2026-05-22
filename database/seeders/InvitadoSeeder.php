<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvitadoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('invitados')->insert([

            [
                'nombre' => 'María López',
                'email' => 'maria.lopez@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 1
            ],
            [
                'nombre' => 'Juan Pérez',
                'email' => 'juan.perez@test.com',
                'confirmacion' => 'pendiente',
                'id_evento' => 1
            ],
            [
                'nombre' => 'Lucía García',
                'email' => 'lucia.garcia@test.com',
                'confirmacion' => 'rechazado',
                'id_evento' => 2
            ],
            [
                'nombre' => 'Carlos Sánchez',
                'email' => 'carlos.sanchez@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 2
            ],
            [
                'nombre' => 'Ana Torres',
                'email' => 'ana.torres@test.com',
                'confirmacion' => 'pendiente',
                'id_evento' => 3
            ],
            [
                'nombre' => 'Pedro Ruiz',
                'email' => 'pedro.ruiz@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 3
            ],
            [
                'nombre' => 'Laura Martín',
                'email' => 'laura.martin@test.com',
                'confirmacion' => 'pendiente',
                'id_evento' => 4
            ],
            [
                'nombre' => 'David Gómez',
                'email' => 'david.gomez@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 4
            ],
            [
                'nombre' => 'Elena Navarro',
                'email' => 'elena.navarro@test.com',
                'confirmacion' => 'rechazado',
                'id_evento' => 5
            ],
            [
                'nombre' => 'Sergio Molina',
                'email' => 'sergio.molina@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 5
            ],
            [
                'nombre' => 'Andrea Castillo',
                'email' => 'andrea.castillo@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 1
            ],
            [
                'nombre' => 'Miguel Herrera',
                'email' => 'miguel.herrera@test.com',
                'confirmacion' => 'pendiente',
                'id_evento' => 2
            ],
            [
                'nombre' => 'Sofía Ramírez',
                'email' => 'sofia.ramirez@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 3
            ],
            [
                'nombre' => 'Daniel Ortega',
                'email' => 'daniel.ortega@test.com',
                'confirmacion' => 'rechazado',
                'id_evento' => 4
            ],
            [
                'nombre' => 'Valeria Díaz',
                'email' => 'valeria.diaz@test.com',
                'confirmacion' => 'pendiente',
                'id_evento' => 5
            ],
            [
                'nombre' => 'Javier Morales',
                'email' => 'javier.morales@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 1
            ],
            [
                'nombre' => 'Paula Romero',
                'email' => 'paula.romero@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 2
            ],
            [
                'nombre' => 'Diego Navarro',
                'email' => 'diego.navarro@test.com',
                'confirmacion' => 'pendiente',
                'id_evento' => 3
            ],
            [
                'nombre' => 'Claudia Vega',
                'email' => 'claudia.vega@test.com',
                'confirmacion' => 'confirmado',
                'id_evento' => 4
            ],
            [
                'nombre' => 'Rubén Gil',
                'email' => 'ruben.gil@test.com',
                'confirmacion' => 'rechazado',
                'id_evento' => 5
            ],
        ]);
    }
}