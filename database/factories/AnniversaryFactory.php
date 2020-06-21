<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Anniversary;
use Faker\Generator as Faker;

$factory->define(Anniversary::class, function (Faker $faker) {
    return [
        'lover_id'=>$faker->numberBetween(1, 400),
        'title'=>$faker->word(),
        'scene_id'=>$faker->numberBetween(1,9),
        'date' => $faker->dateTimeBetween('-40 years', '-0years')->format('Y-m-d'),
    ];
});