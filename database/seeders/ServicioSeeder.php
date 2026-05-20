<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('servicios')->insert([
            ['nombre' => 'Fotógrafo',
            'precio_unitario' => '50.00',
            'descripcion' => 'Cobertura de 2 horas con fotógrafo profesional. Incluye entrega de las fotos digitales en galería online en 5 días. Desplazamiento incluido en un radio de 30 km; suplemento fuera de ese área.'
            ],
            ['nombre' => 'Cuarteto de cuerda',
            'precio_unitario' => '160.00',
            'descripcion' => 'Actuación en vivo de 90 minutos divididos en 3 sets de 30 min con pausas. Repertorio versátil (clásico, pop, bandas sonoras). Requiere espacio de 3x3m con toma de corriente.'
            ],
            ['nombre' => 'DJ',
            'precio_unitario' => '80.00',
            'descripcion' => '2 horas de música mezclada en vivo con equipo de sonido profesional e iluminación básica. Posibilidad de personalizar lista de canciones. Montaje y desmontaje en 30 min antes y después del evento.'
            ],
            ['nombre' => 'Animación infantil',
            'precio_unitario' => '100.00',
            'descripcion' => '1 hora de juego dinámico con monitor especializado: pintacaras, globoflexia, canciones y cuentacuentos. Para grupos de hasta 15 niños. Se recomienda espacio diáfano de 20 m². El monitor lleva su propio material.'
            ],

        ]);
    }
}
