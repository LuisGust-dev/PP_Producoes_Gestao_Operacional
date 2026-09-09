<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['name' => 'Painel', 'icon' => 'screen'],
            ['name' => 'Som', 'icon' => 'audio'],
            ['name' => 'Iluminação', 'icon' => 'light'],
            ['name' => 'Estrutura', 'icon' => 'truss'],
            ['name' => 'Palco', 'icon' => 'stage'],
            ['name' => 'Energia', 'icon' => 'bolt'],
            ['name' => 'Cabos', 'icon' => 'cable'],
            ['name' => 'Ferramentas', 'icon' => 'tool'],
            ['name' => 'Acessórios', 'icon' => 'box'],
            ['name' => 'Outros', 'icon' => 'dots'],
        ])->each(fn (array $category) => Category::updateOrCreate(
            ['name' => $category['name']],
            $category + ['active' => true],
        ));
    }
}
