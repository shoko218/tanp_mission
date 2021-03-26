<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Scene;
use Faker\Generator as Faker;

$factory->define(Scene::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
    ];
});
