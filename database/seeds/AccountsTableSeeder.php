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
        $userModel = new User();

        $userOwner = $userModel->where('name', 'Ricardo')->first();
        $accountTypeOwner = $accountTypeModel->findByUniqueName('owner');

        $userGuest = $userModel->where('name', 'Amanda')->first();
        $accountTypeGuest = $accountTypeModel->findByUniqueName('guest');

        factory(\App\Model\Account::class)->create([
            'account_type_id' => $accountTypeOwner->id,
            'user_id' => $userOwner->id
        ]);

        factory(\App\Model\Account::class)->create([
            'account_type_id' => $accountTypeGuest->id,
			'user_id' => $userGuest->id
        ]);
    }
}
