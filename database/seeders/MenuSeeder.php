<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu')->insert([
            [
                'nombre' => 'Menú 1',
                'descripcion' => '  ##Entrantes##
                                    Snacks variados (palitos de queso, patatas, fritos, aceitunas)
                                    Mini empanadas de carne y pollo
                                    Nachos y zanahoria con guacamole

                                    ##Plato principal (a elegir)##
                                    Pizza con jamón o napolitana
                                    Hamburguesa completa con patatas fritas

                                    ##Bebida##
                                    Barra libre de refrescos, agua, zumo, y cerveza (2 por persona)

                                    ##Postre##
                                    Helado de vainilla o chocolate
                                    Porción de tarta  (queso, chocolate, limón)
                                    Café o té
                                ',
                'precio_unitario' => '11.60',
                'tipo_menu' => 'estandar'
            ],
            [
                'nombre' => 'Menú 2',
                'descripcion' => '  ##Entrantes##
                                    Tabla de fiambres y quesos (jamón crudo, cocido, salame, queso crema, dambo)
                                    Canapés variados (salmón, rúcula con queso, palmitos)
                                    Mini tartaletas de verdura y choclo
                                    Opción caliente: dedos de mozzarella o langostinos rebosados

                                    ##Plato principal (a elegir)##
                                    Carne: Entrecot a la parrilla con salsa de vino tinto, con puré de patatas y espárragos verdes salteados
                                    Pescado: Lubina al horno sobre cama de hinojo, salsa de cítricos y verduras asadas
                                    Vegetal: Curry de garbanzos y espinacas con leche de coco, arroz basmati y crujiente de frutos secos

                                    ##Bebida##
                                    Barra libre de refrescos, agua, zumo, y cerveza (2 por persona)
                                    Opción de vino de la casa (1 botella cada 4 personas)

                                    ##Postre##
                                    Mesa de mini postres: brownies, tarta de celebración personalizada, frutas frescas con chocolate
                                    Café o té
                                ',
                'precio_unitario' => '20.50',
                'tipo_menu' => 'estandar'
            ],
            [
                'nombre' => 'Menú 3',
                'descripcion' => '  ##Entrantes##
                                    Estación de sushi y rolls (salmón, palta, pepino, cream cheese)
                                    Estación de mariscos (ostiones, camarones al ajillo, ceviche)
                                    Tablas premium de quesos azules, brie, camembert, con miel y nueces
                                    Jamón ibérico cortado al momento
                                    Mini hamburguesas de wagyu o salmón ahumado

                                    ##Plato principal (a elegir)##
                                    Solomillo de buey con salsa de oporto, gratín de boniato y espárragos trigueros y chips de remolacha
                                    Rodaballo sobre crema de coliflor, alcaparras fritas, cebollino y tempura de verduras
                                    Alcachofa rellena de setas y trufa, cremoso de patata y reducción de Pedro Ximénez

                                    ##Bebida##
                                    Barra libre premium
                                    Cócteles personalizados
                                    Barra libre de refrescos, agua, zumo, y cerveza (2 por persona)
                                    Opción de vino de la casa (1 botella cada 4 personas)

                                    ##Postre##
                                    Fuente de chocolate con frutas
                                    Tarta de celebración personalizada
                                    Mesa de pastelería: macarons, profiteroles, tarta de frutos rojos
                                    Café o té
                                ',
                'precio_unitario' => '27.70',
                'tipo_menu' => 'estandar'
            ],
            [
                'nombre' => 'Menú 4 Coffee Break',
                'descripcion' => '  ##Platos##
                                    Croissants de mantequilla, napolitanas, magdalenas
                                    Sándwiches variados (jamón York y queso, atún y tomate, vegetal)
                                    Frutas variadas (manzana, pera, plátano, mandarina)
                                    Mini muffins de chocolate y vainilla
                                    Yogur natural

                                    ##Bebidas##
                                    Café, té, infusiones
                                    Zumos naturales
                                    Agua mineral
                                ',
                'precio_unitario' => '12.70',
                'tipo_menu' => 'estandar'
            ],
            
        ]);
    }
}
