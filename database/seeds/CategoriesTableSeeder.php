<?php

use App\Model\Category;
use App\User;
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
		$userModel = new User();
		$user = $userModel->where('name', 'Ricardo')->first();

        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Salário']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Aluguel']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Financiamento Apartamento']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Teka Maria']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Farmácia']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Lazer']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Telefonia']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Seguro']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Carro']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Despesas Bancárias']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Transferência entre contas']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Indefinida']);
    }
}
