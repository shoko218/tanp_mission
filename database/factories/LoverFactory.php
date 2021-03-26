<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Lover;
use App\Model\Prefecture;
use App\Model\Relationship;
use App\User;
use Faker\Generator as Faker;

$factory->define(Lover::class, function (Faker $faker) {
    $user = User::inRandomOrder()->first();
    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'last_name_furigana' => $faker->lastKanaName,
        'first_name_furigana' => $faker->firstKanaName,
        'birthday' => $faker->dateTimeBetween('-90 years', '-15years')->format('Y-m-d'),
        'gender'=>$faker->numberBetween(0, 2),
        'postal_code'=>$faker->postcode,
        'prefecture_id'=>Prefecture::inRandomOrder()->first()->id,
        'address'=>$faker->city.$faker->streetAddress,
        'telephone' => str_replace('-','',$faker->phoneNumber),
        'relationship_id'=>Relationship::inRandomOrder()->first()->id,
        'user_id'=>$user!=null ? $user->id : factory(User::class),
    ];
});
