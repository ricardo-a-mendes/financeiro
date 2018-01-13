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
        $account = \App\Model\Account::first();

        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Undefined']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Salary']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Savings']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Tenancy']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'University']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Loan']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Teka Maria']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Drug Store']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Fun']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'House']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Cable TV']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Mobile']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Energy']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Bank Transfer']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Ricardo Lunch']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Amanda Lunch']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Family Lunch']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Supermarket']);
        factory(Category::class)->create(['account_id' => $account->id, 'name' => 'Health']);
    }
}
