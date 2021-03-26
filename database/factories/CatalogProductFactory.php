<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Catalog;
use App\Model\CatalogProduct;
use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(CatalogProduct::class, function (Faker $faker) {
    $catalog = Catalog::inRandomOrder()->first();
    $product = Product::inRandomOrder()->first();
    return [
        'catalog_id' => $catalog!=null ? ($faker->boolean(40) ? $catalog->id : factory(Catalog::class)) : factory(Catalog::class),
        'product_id' => $product!=null ? ($faker->boolean(20) ? $product->id : factory(Product::class)) : factory(Product::class)
    ];
});
