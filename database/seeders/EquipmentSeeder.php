<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Painel', 'Gabinete LED', 'PP-LED-GAB', 42, 'unidades', 'Modulo principal para composicao de paineis.'],
            ['Painel', 'VC4', 'PP-VC4', 1, 'unidade', 'Processadora de video.'],
            ['Painel', 'Notebook', 'PP-NOTE', 1, 'unidade', 'Notebook para operacao de midia.'],
            ['Som', 'Grave', 'PP-GRV', 4, 'unidades', 'Subwoofer para sonorização.'],
            ['Som', 'Medio', 'PP-MED', 4, 'unidades', 'Caixa de medio/agudo.'],
            ['Cabos', 'HDMI', 'PP-HDMI', 8, 'unidades', 'Cabos HDMI para video.'],
            ['Cabos', 'Cabo de rede', 'PP-REDE', 20, 'unidades', 'Cabos de rede para painel.'],
        ];

        foreach ($items as [$categoryName, $name, $code, $quantity, $unit, $description]) {
            $category = Category::where('name', $categoryName)->first();

            Equipment::updateOrCreate(
                ['code' => $code],
                [
                    'category_id' => $category->id,
                    'name' => $name,
                    'total_quantity' => $quantity,
                    'unit' => $unit,
                    'description' => $description,
                    'status' => 'available',
                    'active' => true,
                ],
            );
        }
    }
}
