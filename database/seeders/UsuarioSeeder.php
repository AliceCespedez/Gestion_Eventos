<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'nombre' => 'Alice',
                'email' => 'alice@test.com',
                'rol' => 'admin'
            ],
            [
                'nombre' => 'Aaruni',
                'email' => 'aaruni@test.com',
                'rol' => 'admin'
            ],
            [
                'nombre' => 'Laura',
                'email' => 'laura@test.com',
                'rol' => 'empleado'
            ],
            [
                'nombre' => 'Carlos',
                'email' => 'carlos@test.com',
                'rol' => 'cliente'
            ],
        ];

        foreach ($usuarios as $u) {
            Usuario::firstOrCreate(
                ['email' => $u['email']],
                [
                    'nombre' => $u['nombre'],
                    'password' => Hash::make('12345678'),
                    'rol' => $u['rol']
                ]
            );
        }
    }
}
