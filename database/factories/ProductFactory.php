<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Genre;
use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->numberBetween(1000, 30000),
        'genre_id' => Genre::inRandomOrder()->first()->id,
        'description' => $faker->realText(200, 2),
    ];
});
