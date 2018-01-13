<?php

use App\User;
use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountTypeModel = new App\Model\AccountType();
        $accountTypeOwner = $accountTypeModel->findByUniqueName('owner');

        factory(\App\Model\Account::class)->create([
            'account_type_id' => $accountTypeOwner->id
        ]);
    }
}
