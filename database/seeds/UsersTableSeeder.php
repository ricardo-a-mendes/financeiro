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
        factory(\App\User::class)->create([
            'name' => 'Adminstrador',
            'email' => 'admin@financeiro.com.br',
            'password' => bcrypt('secret'),
            'remember_token' => 'secret',
        ]);

        factory(\App\User::class)->create([
            'name' => 'Ricardo',
            'email' => 'ricardo@financeiro.com.br',
            'password' => bcrypt('secret'),
            'remember_token' => 'secret',
        ]);
        factory(\App\User::class)->create([
            'name' => 'Amanda',
            'email' => 'amanda@financeiro.com.br',
            'password' => bcrypt('secret'),
            'remember_token' => 'secret',
        ]);
    }
}
