<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Cart;
use App\Model\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(Cart::class, function (Faker $faker) {
    $user = User::inRandomOrder()->first();
    $product = Product::inRandomOrder()->first();

    if($user !== null && $product !== null && Cart::where('user_id',$user->id)->where('product_id',$product->id)->first() !== null){
        $product = null;
    }
    return [
        'user_id'=>$user !== null ? $user->id : factory(User::class),
        'product_id'=>$product !== null ? $product->id : factory(Product::class),
    ];

});
