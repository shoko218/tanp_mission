<?php

namespace Tests\Feature\Controller\Main\Cart;

use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartInTest extends TestCase
{
    use RefreshDatabase;

    public function testCanAddToNotAuthCart()//未ログイン時にカートに商品を入れられるかどうか
    {
        $this->seed('BaseSeeder');//戻す
        $product = factory(Product::class)->create();
        $response = $this->post('/cart/in/',[
            'product_id' => $product->id,
        ]);
        $response->assertCookie('cart_product_ids',$product->id.',');
    }

    public function testCanAddToCart()//ログイン時にカートに商品を入れられるかどうか
    {
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $response = $this->actingAs($user)
            ->post('/cart/in/',[
                'product_id' => $product->id,
            ]);
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'count' => 1
        ]);

        $response = $this->actingAs($user)//2個目の場合countを増やせているか
            ->post('/cart/in/',[
                'product_id' => $product->id,
            ]);
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'count' => 2
        ]);
    }
}
