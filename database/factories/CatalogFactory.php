<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Catalog;
use Faker\Generator as Faker;
use App\User;

$factory->define(Catalog::class, function (Faker $faker) {
    $user = User::inRandomOrder()->first();
    return [
        'user_id' => $user!=null ? $user->id : factory(User::class),
        'email' => $faker->unique()->safeEmail,
        'name' => $faker->lastName,
        'url_str' => strtolower(substr(str_replace(['/', '+'], ['_'], base64_encode(random_bytes(32))), 0, 32)),
        'img_num' => $faker->numberBetween(0, 10),
        'did_check_reply' => false,
        'selected_id' => null,
        'did_send_mail' =>false
    ];
});
