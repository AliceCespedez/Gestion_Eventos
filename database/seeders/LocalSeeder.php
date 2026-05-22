<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('locales')->insert([
            [
                'nombre' => 'Salón Imperial Madrid',
                'direccion' => 'Calle Alcalá 120, Madrid',
                'capacidad' => 250,
                'telefono' => '912345678',
                'descripcion' => 'Salón elegante ideal para bodas y eventos corporativos. Amplio, moderno y con iluminación profesional.',
                'precio' => 1200.00
            ],
            [
                'nombre' => 'Jardines El Retiro Eventos',
                'direccion' => 'Parque El Retiro, Madrid',
                'capacidad' => 180,
                'telefono' => '913456789',
                'descripcion' => 'Espacio al aire libre rodeado de naturaleza. Perfecto para bodas y celebraciones al aire libre.',
                'precio' => 900.00
            ],
            [
                'nombre' => 'Centro Eventos Castellana',
                'direccion' => 'Paseo de la Castellana 45, Madrid',
                'capacidad' => 300,
                'telefono' => '914567890',
                'descripcion' => 'Centro moderno para congresos, conferencias y eventos empresariales.',
                'precio' => 1500.00
            ],
            [
                'nombre' => 'Finca La Estrella',
                'direccion' => 'Carretera M-607 Km 12, Madrid',
                'capacidad' => 400,
                'telefono' => '915678901',
                'descripcion' => 'Finca exclusiva para bodas y grandes eventos con jardines y salón interior.',
                'precio' => 2000.00
            ],
            [
                'nombre' => 'Hotel Palacio Eventos',
                'direccion' => 'Gran Vía 60, Madrid',
                'capacidad' => 150,
                'telefono' => '916789012',
                'descripcion' => 'Hotel céntrico con salones privados para eventos pequeños y medianos.',
                'precio' => 1100.00
            ],
            [
                'nombre' => 'Espacio Loft Industrial',
                'direccion' => 'Calle Embajadores 88, Madrid',
                'capacidad' => 120,
                'telefono' => '917890123',
                'descripcion' => 'Espacio moderno estilo industrial ideal para fiestas privadas y eventos creativos.',
                'precio' => 800.00
            ],
            [
                'nombre' => 'Terraza Skyline Madrid',
                'direccion' => 'Azotea Gran Vía 28, Madrid',
                'capacidad' => 100,
                'telefono' => '918901234',
                'descripcion' => 'Terraza con vistas panorámicas de Madrid ideal para cócteles y eventos exclusivos.',
                'precio' => 950.00
            ],
            [
                'nombre' => 'Salón Aurora',
                'direccion' => 'Calle Toledo 33, Madrid',
                'capacidad' => 200,
                'telefono' => '919012345',
                'descripcion' => 'Salón clásico con decoración elegante para celebraciones familiares.',
                'precio' => 1000.00
            ],
            [
                'nombre' => 'Centro Cultural Norte',
                'direccion' => 'Avenida Monforte de Lemos 45, Madrid',
                'capacidad' => 350,
                'telefono' => '910123456',
                'descripcion' => 'Espacio amplio para eventos culturales, conferencias y exposiciones.',
                'precio' => 1300.00
            ],
            [
                'nombre' => 'La Hacienda Real',
                'direccion' => 'Camino de la Dehesa, Madrid',
                'capacidad' => 500,
                'telefono' => '911234567',
                'descripcion' => 'Hacienda tradicional con grandes jardines, ideal para bodas de gran tamaño.',
                'precio' => 2500.00
            ],
        ]);
    }
}