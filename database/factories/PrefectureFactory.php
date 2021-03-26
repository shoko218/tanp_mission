<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Prefecture;
use Faker\Generator as Faker;

$factory->define(Prefecture::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
    ];
});
