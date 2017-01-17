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
        $accountType = $accountTypeModel->findByUniqueName('conta_corrente');

		$userModel = new User();
		$user = $userModel->where('name', 'Ricardo')->first();

        factory(\App\Model\Account::class)->create([
            'account_type_id' => $accountType->id,
            'user_id' => $user->id,
            'name' => 'Itau',
        ]);

        factory(\App\Model\Account::class)->create([
            'account_type_id' => $accountType->id,
			'user_id' => $user->id,
            'name' => 'Santander',
        ]);

        factory(\App\Model\Account::class)->create([
            'account_type_id' => $accountType->id,
			'user_id' => $user->id,
            'name' => 'Banco do Brasil',
        ]);

        factory(\App\Model\Account::class)->create([
            'account_type_id' => $accountType->id,
			'user_id' => $user->id,
            'name' => 'Caixa',
        ]);
    }
}
