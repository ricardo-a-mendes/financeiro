<?php

use App\User;
use Illuminate\Database\Seeder;

class GoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactionType = new \App\Model\TransactionType();
        $category = new \App\Model\Category();

        $credit = $transactionType->findByUniqueName('credit');
        $debit = $transactionType->findByUniqueName('debit');

        $salario = $category->findByName('Salário');
        $aluguel = $category->findByName('Aluguel');
        $teka = $category->findByName('Teka Maria');
        $financiamento = $category->findByName('Financiamento Apartamento');

		$userModel = new User();
		$user = $userModel->where('name', 'Ricardo')->first();

        factory(\App\Model\Goal::class)->create([
            'category_id' => $salario->id,
            'transaction_type_id' => $credit->id,
			'user_id' => $user->id,
            'value' => 5600,
        ]);

        factory(\App\Model\Goal::class)->create([
            'category_id' => $aluguel->id,
            'transaction_type_id' => $debit->id,
			'user_id' => $user->id,
            'value' => 1430,
        ]);

        factory(\App\Model\Goal::class)->create([
            'category_id' => $teka->id,
            'transaction_type_id' => $debit->id,
			'user_id' => $user->id,
            'value' => 300,
        ]);

        factory(\App\Model\Goal::class)->create([
            'category_id' => $financiamento->id,
            'transaction_type_id' => $debit->id,
			'user_id' => $user->id,
            'value' => 3125,
        ]);

    }
}
