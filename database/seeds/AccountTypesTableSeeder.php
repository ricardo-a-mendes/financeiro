<?php

use Illuminate\Database\Seeder;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Model\AccountType::class)->create([
            'unique_name' => 'conta_corrente',
        ]);

        factory(\App\Model\AccountType::class)->create([
            'unique_name' => 'conta_poupanca',
        ]);

        factory(\App\Model\AccountType::class)->create([
            'unique_name' => 'cartao_credito',
        ]);
    }
}
