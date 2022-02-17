<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

$factory->define(App\User::class, function (Faker $faker) {
    $firstName = $faker->firstName;
    return [
        'first_name' => $firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'password' => Hash::make($firstName),
        'api_token' => Base64_encode(Str::random(40)),
    ];
});

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'title' => $faker->company,
        'phone' => $faker->phoneNumber,
        'description' => $faker->text,
    ];
});
