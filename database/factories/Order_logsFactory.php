<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Order;
use App\Model\Order_log;
use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(Order_log::class, function (Faker $faker) {
    $order = Order::inRandomOrder()->first();
    $product = Product::inRandomOrder()->first();
    if($order !== null && $product !== null && Order_log::where('order_id',$order->id)->where('product_id',$product->id)->first() !== null){
        $product = null;
    }
    return [
        'order_id'=>$order !== null ? $order->id : factory(Order::class),
        'product_id'=>$product !== null ? $product->id : factory(Product::class),
        'count'=>$faker->numberBetween(1, 10),
    ];
});
