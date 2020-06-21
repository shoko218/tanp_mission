<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Lover;
use Faker\Generator as Faker;

$factory->define(Lover::class, function (Faker $faker) {
    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'last_name_furigana' => $faker->lastKanaName,
        'first_name_furigana' => $faker->firstKanaName,
        'birthday' => $faker->dateTimeBetween('-90 years', '-15years')->format('Y-m-d'),
        'gender'=>$faker->numberBetween(0, 2),
        'postal_code'=>$faker->postcode,
        'prefecture_id'=>$faker->numberBetween(1, 47),
        'address'=>$faker->city.$faker->streetAddress,
        'telephone'=>$faker->phoneNumber,
        'relationship_id'=>$faker->numberBetween(1, 13),
        'user_id'=>$faker->numberBetween(1, 200),
    ];
});
