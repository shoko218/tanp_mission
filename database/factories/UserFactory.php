<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\Prefecture;

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
    $prefecture=Prefecture::get();
    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'last_name_furigana' => $faker->lastKanaName,
        'first_name_furigana' => $faker->firstKanaName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'birthday' => $faker->dateTimeBetween('-40 years', '-15years')->format('Y-m-d'),
        'gender'=>$faker->numberBetween(0, 2),
        'postal_code'=>$faker->postcode,
        'prefecture_id'=>Prefecture::inRandomOrder()->first()->id,
        'address'=>$faker->city.$faker->streetAddress,
        'telephone' => str_replace('-','',$faker->phoneNumber),
        'remember_token' => Str::random(10),
    ];
});
