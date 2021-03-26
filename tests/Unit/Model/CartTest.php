<?php

namespace Tests\Unit\Model;

use App\Model\Cart;
use App\Model\Prefecture;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        $eloquent = app(Cart::class);
        $this->assertEmpty($eloquent->get());
        factory(Cart::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testCartBelongsToProduct()
    {
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        $cart = factory(Cart::class)->create([
            'product_id' => $product->id,
        ]);
        $this->assertNotEmpty($cart->product);
    }
}
