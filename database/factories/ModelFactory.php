<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'name' => 'Adminstrador',
        'email' => 'admin@financeiro.com.br',
        'password' => bcrypt('secret'),
        'remember_token' => 'secret',
    ];
});

$factory->define(App\Model\Category::class, function (Faker\Generator $faker) { return []; });
$factory->define(App\Model\TransactionType::class, function (Faker\Generator $faker) { return []; });
$factory->define(App\Model\AccountType::class, function (Faker\Generator $faker) { return []; });
$factory->define(App\Model\Account::class, function (Faker\Generator $faker) { return []; });
$factory->define(App\Model\Provision::class, function (Faker\Generator $faker) { return []; });
