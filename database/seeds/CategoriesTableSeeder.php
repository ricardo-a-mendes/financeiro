<?php

use App\Model\Category;
use App\User;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * @var integer
     */
    private $accountId = null;

    /**
     * @param int $accountId
     * @return CategoriesTableSeeder
     */
    public function setAccountId(int $accountId): CategoriesTableSeeder
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (is_null($this->accountId)) {
            $account = \App\Model\Account::first();
            $this->accountId = $account->id;
        }

        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Undefined']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Salary']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Savings']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Tenancy']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'University']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Loan']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Teka Maria']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Drug Store']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Fun']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'House']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Cable TV']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Mobile']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Energy']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Bank Transfer']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Ricardo Lunch']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Amanda Lunch']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Family Lunch']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Supermarket']);
        factory(Category::class)->create(['account_id' => $this->accountId, 'name' => 'Health']);
    }
}
