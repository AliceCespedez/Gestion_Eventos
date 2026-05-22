<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('servicios')->insert([

            [
                'nombre' => 'Fotógrafo',
                'precio_unitario' => 50.00,
                'descripcion' => 'Cobertura de 2 horas con fotógrafo profesional. Incluye entrega de las fotos digitales en galería online en 5 días. Desplazamiento incluido en un radio de 30 km; suplemento fuera de ese área.'
            ],
            [
                'nombre' => 'Cuarteto de cuerda',
                'precio_unitario' => 160.00,
                'descripcion' => 'Actuación en vivo de 90 minutos divididos en 3 sets de 30 min con pausas. Repertorio versátil (clásico, pop, bandas sonoras). Requiere espacio de 3x3m con toma de corriente.'
            ],
            [
                'nombre' => 'DJ',
                'precio_unitario' => 150.00,
                'descripcion' => '2 horas de música mezclada en vivo con equipo de sonido profesional e iluminación básica. Posibilidad de personalizar lista de canciones. Montaje y desmontaje en 30 min antes y después del evento.'
            ],
            [
                'nombre' => 'Animación infantil',
                'precio_unitario' => 100.00,
                'descripcion' => '1 hora de juego dinámico con monitor especializado: pintacaras, globoflexia, canciones y cuentacuentos. Para grupos de hasta 15 niños. Se recomienda espacio diáfano de 20 m².'
            ],

            [
                'nombre' => 'Barra libre de cócteles',
                'precio_unitario' => 25.00,
                'descripcion' => 'Bartender profesional con selección de cócteles clásicos y personalizados durante 3 horas. Incluye bebidas y utensilios.'
            ],
            [
                'nombre' => 'Decoración floral',
                'precio_unitario' => 120.00,
                'descripcion' => 'Decoración con flores naturales para mesas, espacios y entrada del evento. Diseño personalizado según temática.'
            ],
            [
                'nombre' => 'Fotomatón',
                'precio_unitario' => 90.00,
                'descripcion' => 'Cabina de fotos instantáneas con disfraces y accesorios. Incluye impresiones ilimitadas durante 2 horas.'
            ],
            [
                'nombre' => 'Iluminación ambiental',
                'precio_unitario' => 110.00,
                'descripcion' => 'Montaje de luces LED decorativas y efectos ambientales para crear atmósferas personalizadas en el evento.'
            ],
            [
                'nombre' => 'Maestro de ceremonias',
                'precio_unitario' => 150.00,
                'descripcion' => 'Presentador profesional para guiar el evento, coordinar tiempos y dinamizar actividades.'
            ],
            [
                'nombre' => 'Seguridad privada',
                'precio_unitario' => 200.00,
                'descripcion' => 'Servicio de seguridad con personal cualificado para control de acceso y vigilancia durante el evento.'
            ],
            [
                'nombre' => 'Transporte VIP',
                'precio_unitario' => 300.00,
                'descripcion' => 'Servicio de transporte en vehículo de alta gama con conductor para invitados o anfitriones.'
            ],
        ]);
    }
}