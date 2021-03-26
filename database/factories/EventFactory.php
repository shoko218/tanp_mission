<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Event;
use App\Model\Lover;
use App\Model\Scene;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $lover = Lover::inRandomOrder()->first();
    return [
        'lover_id'=>$lover!=null ? $lover->id : factory(Lover::class),
        'title'=>$faker->word(),
        'scene_id'=>Scene::inRandomOrder()->first()->id,
        'date' => $faker->dateTimeBetween('tomorrow', '+1years')->format('Y-m-d'),
        'is_repeat'=>false
    ];
});
