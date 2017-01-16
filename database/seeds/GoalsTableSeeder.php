<?php

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

        $credit = $transactionType->getByUniqueName('credit');
        $debit = $transactionType->getByUniqueName('debit');

        $salario = $category->findByName('Salário');
        $aluguel = $category->findByName('Aluguel');
        $teka = $category->findByName('Teka Maria');
        $financiamento = $category->findByName('Financiamento Apartamento');

        factory(\App\Model\Account::class)->create([
            'category_id' => $salario->id,
            'transaction_type_id' => $credit->id,
            'value' => 5600,
        ]);

        factory(\App\Model\Account::class)->create([
            'category_id' => $aluguel->id,
            'transaction_type_id' => $debit->id,
            'value' => 1430,
        ]);

        factory(\App\Model\Account::class)->create([
            'category_id' => $teka->id,
            'transaction_type_id' => $debit->id,
            'value' => 300,
        ]);

        factory(\App\Model\Account::class)->create([
            'category_id' => $financiamento->id,
            'transaction_type_id' => $debit->id,
            'value' => 3125,
        ]);
    }
}
