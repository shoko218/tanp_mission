<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Favorite;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->numberBetween(1, 200),
        'product_id'=>$faker->numberBetween(1, 75),
    ];
});
