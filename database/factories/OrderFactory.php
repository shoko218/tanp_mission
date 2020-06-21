<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Order;
use App\Model\Lover;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $user_id=$faker->numberBetween(1, 200);
    $faker->boolean(20) ? (Lover::where('user_id',$user_id)->first() ? $lover=Lover::where('user_id',$user_id)->first() :$lover=null) :$lover=null;

    return [
        'user_id'=>$user_id,
        'product_id'=>$faker->numberBetween(1, 75),
        'lover_id'=>$lover ? $lover->id :null,
        'scene_id'=>$faker->boolean(80) ? $faker->numberBetween(1, 15) : null,
        'date'=>$faker->dateTimeBetween('-2 years', '-0years')->format('Y-m-d'),
        'last_name' => $lover ? $lover->last_name : $faker->lastName ,
        'first_name' => $lover ? $lover->first_name : $faker->firstName ,
        'last_name_furigana' => $lover ? $lover->last_name_furigana : $faker->lastKanaName ,
        'first_name_furigana' => $lover ? $lover->first_name_furigana : $faker->firstKanaName ,
        'postal_code'=>$lover ? $lover->postal_code : $faker->postcode,
        'prefecture_id'=>$lover ? $lover->prefecture_id: $faker->numberBetween(1, 47),
        'address'=>$lover ? $lover->address: $faker->city.$faker->streetAddress,
        'telephone'=>$lover ? $lover->telephone: $faker->phoneNumber,
        'gender'=>$lover ? $lover->gender: $faker->numberBetween(0, 2),
        'age'=>$lover ? floor((intval(date ( 'Ymd', time ()))-intval(str_replace('-', '', $lover->birthday)))/10000): $faker->numberBetween(15, 90),
        'relationship_id'=>$lover ? $lover->relationship_id: $faker->numberBetween(1, 13),
    ];
});
