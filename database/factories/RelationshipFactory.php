<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Relationship;
use Faker\Generator as Faker;

$factory->define(Relationship::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
    ];
});
