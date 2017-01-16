<?php

use App\Model\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class)->create([
            'id' => 0,
            'name' => 'Indefinida',
        ]);

        factory(Category::class)->create(['name' => 'Salário']);
        factory(Category::class)->create(['name' => 'Aluguel']);
        factory(Category::class)->create(['name' => 'Financiamento Apartamento']);
        factory(Category::class)->create(['name' => 'Teka Maria']);
        factory(Category::class)->create(['name' => 'Farmácia']);
        factory(Category::class)->create(['name' => 'Lazer']);
        factory(Category::class)->create(['name' => 'Telefonia']);
        factory(Category::class)->create(['name' => 'Seguro']);
        factory(Category::class)->create(['name' => 'Carro']);
        factory(Category::class)->create(['name' => 'Despesas Bancárias']);
        factory(Category::class)->create(['name' => 'Transferência entre contas']);
    }
}
