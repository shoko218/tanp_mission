<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Order;
use App\Model\Lover;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    return [
        'user_id'=>$faker->numberBetween(1, 200),
        'lover_id'=>null,
        'scene_id'=>$faker->boolean(80) ? $faker->numberBetween(1, 16) : null,
        'last_name' => $faker->lastName ,
        'first_name' => $faker->firstName ,
        'last_name_furigana' => $faker->lastKanaName ,
        'first_name_furigana' => $faker->firstKanaName ,
        'postal_code'=>$faker->postcode,
        'prefecture_id'=>$faker->numberBetween(1, 47),
        'address'=>$faker->city.$faker->streetAddress,
        'telephone'=>$faker->phoneNumber,
        'gender'=>$faker->numberBetween(0, 2),
        'generation_id'=>$faker->numberBetween(1, 10),
        'relationship_id'=>$faker->numberBetween(1, 14),
        'user_last_name' =>$faker->lastName ,
        'user_first_name' =>$faker->firstName ,
        'user_last_name_furigana' =>$faker->lastKanaName ,
        'user_first_name_furigana' =>$faker->firstKanaName ,
        'user_postal_code'=>$faker->postcode,
        'user_prefecture_id'=>$faker->numberBetween(1, 47),
        'user_address'=>$faker->city.$faker->streetAddress,
        'user_telephone'=>$faker->phoneNumber,
        'user_email'=> $faker->unique()->safeEmail,
    ];
});
