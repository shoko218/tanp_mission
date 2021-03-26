<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Generation;
use Faker\Generator as Faker;

$factory->define(Generation::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
        'min_age' => $faker->numberBetween(0, 200),
        'max_age' => $faker->numberBetween(0, 200),
    ];
});
