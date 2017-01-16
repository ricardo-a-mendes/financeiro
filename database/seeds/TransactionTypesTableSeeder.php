<?php

use Illuminate\Database\Seeder;

class TransactionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Model\TransactionType::class)->create(['unique_name' => 'credit']);
        factory(\App\Model\TransactionType::class)->create(['unique_name' => 'debit']);
    }
}
