<?php

namespace Tests\Unit\Model;

use App\Model\Product;
use Tests\TestCase;
use App\Model\Genre;
use App\Model\Cart;
use App\Model\Order_log;
use App\Model\Catalog;
use App\Model\CatalogProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        Product::query()->delete();
        $eloquent = app(Product::class);
        $this->assertEmpty($eloquent->get());
        factory(Product::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testProductBelongsToGenre()
    {
        $this->seed('BaseSeeder');
        $genre = factory(Genre::class)->create();
        $product = factory(Product::class)->create([
            'genre_id' => $genre->id,
        ]);
        $this->assertNotEmpty($product->genre);
    }

    public function testProductHasManyCarts()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        factory(Cart::class,$count)->create([
            'product_id' => $product->id,
        ]);
        $this->assertEquals($count,count($product->refresh()->carts));
    }

    public function testProductHasManyOrder_logs()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        factory(Order_log::class,$count)->create([
            'product_id' => $product->id,
        ]);
        $this->assertEquals($count,count($product->refresh()->order_logs));
    }

    public function testProductBelongsToManyCatalogs()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        factory(CatalogProduct::class,$count)->create([
            'product_id' => $product->id,
        ]);
        $this->assertEquals($count,count($product->refresh()->catalogs));
    }
}
