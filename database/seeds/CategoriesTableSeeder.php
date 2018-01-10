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
		$user = $userModel->where('email', 'admin@financeiro.com.br')->first();

        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Undefined']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Salary']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Savings']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Tenancy']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'University']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Loan']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Teka Maria']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Drug Store']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Fun']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'House']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Cable TV']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Mobile']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Energy']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Bank Transfer']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Ricardo Lunch']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Amanda Lunch']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Family Lunch']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Supermarket']);
        factory(Category::class)->create(['user_id' => $user->id, 'name' => 'Health']);
    }
}
