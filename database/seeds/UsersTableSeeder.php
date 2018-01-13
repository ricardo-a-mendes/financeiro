<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = \App\Model\Account::first();
        factory(\App\User::class)->create([
            'account_id' => $account->id,
            'name' => 'Adminstrador',
            'email' => 'admin@financeiro.com.br',
            'password' => bcrypt('secret'),
            'remember_token' => 'secret',
        ]);

        factory(\App\User::class)->create([
            'account_id' => $account->id,
            'name' => 'Ricardo',
            'email' => 'ricardo@financeiro.com.br',
            'password' => bcrypt('secret'),
            'remember_token' => 'secret',
        ]);
        factory(\App\User::class)->create([
            'account_id' => $account->id,
            'name' => 'Amanda',
            'email' => 'amanda@financeiro.com.br',
            'password' => bcrypt('secret'),
            'remember_token' => 'secret',
        ]);
    }
}
