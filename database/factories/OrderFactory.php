<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Generation;
use App\Model\Order;
use App\Model\Lover;
use App\Model\Prefecture;
use App\Model\Relationship;
use App\Model\Scene;
use App\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $user = User::inRandomOrder()->first();
    $lover = Lover::inRandomOrder()->first();

    return [
        'user_id'=>$user!=null ? $user->id : factory(User::class),
        'lover_id'=>$lover!=null ? $lover->id : factory(Lover::class),
        'scene_id' => $faker->boolean(80) ? Scene::inRandomOrder()->first()->id : null,
        'forwarding_last_name' => $faker->lastName ,
        'forwarding_first_name' => $faker->firstName ,
        'forwarding_last_name_furigana' => $faker->lastKanaName ,
        'forwarding_first_name_furigana' => $faker->firstKanaName ,
        'forwarding_postal_code' => $faker->postcode,
        'forwarding_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
        'forwarding_address' => $faker->city.$faker->streetAddress,
        'forwarding_telephone' => str_replace('-','',$this->faker->phoneNumber),
        'gender' => $faker->numberBetween(0, 2),
        'generation_id' => Generation::inRandomOrder()->first()->id,
        'relationship_id' => Relationship::inRandomOrder()->first()->id,
        'user_last_name' => $faker->lastName ,
        'user_first_name' => $faker->firstName ,
        'user_last_name_furigana' => $faker->lastKanaName ,
        'user_first_name_furigana' => $faker->firstKanaName ,
        'user_postal_code' => $faker->postcode,
        'user_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
        'user_address' => $faker->city.$faker->streetAddress,
        'user_telephone' => str_replace('-','',$this->faker->phoneNumber),
        'user_email' => $faker->unique()->safeEmail,
    ];
});
