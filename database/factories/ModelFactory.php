<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\CompactDisc;
use App\UserRentCompactDisc;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $password = app('hash')->make($faker->password);
    return [
        'username' => $faker->userName,
        'email' => $faker->email,
        'password' => $password,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,        
        'address' => $faker->address
    ];
});

$factory->define(CompactDisc::class, function (Faker $faker) {
    return [
        'title' => $faker->firstName,
        'rate' => $faker->randomFloat($nbMaxDecimals = 5, $min = 0, $max = 5),
        'category' => $faker->lastName,
        'quantity' => $faker->numberBetween($min = 0, $max = 50)
    ];
});

$factory->define(UserRentCompactDisc::class, function (Faker $faker){
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 30),
        'compact_disc_id' => $faker->numberBetween($min = 1, $max = 30),
        'rent_date' => new Datetime('now'),
        'return_date' => $faker->dateTimeBetween('+1 week', '+1 month')
    ];
});