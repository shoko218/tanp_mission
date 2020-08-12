<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Order_log;
use Faker\Generator as Faker;

$factory->define(Order_log::class, function (Faker $faker) {
    return [
        'order_id'=>$faker->numberBetween(1001, 1400),
        'product_id'=>$faker->numberBetween(1, 75),
        'count'=>$faker->numberBetween(1, 3),
    ];
});
