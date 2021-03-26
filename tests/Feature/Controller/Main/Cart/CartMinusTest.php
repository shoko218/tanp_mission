<?php

namespace Tests\Feature\Controller\Main\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Model\Cart;
use App\Model\Product;

class CartMinusTest extends TestCase
{
    use DatabaseMigrations;
    //scenesテーブルのidに依存しているため、ここではDatabaseMigrationsを使用

    public function testCanMinusCart()//ログイン時にカートから商品を減らせるかどうか
    {
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $products = factory(Product::class,2)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'count' => 2
            ]);
            $this->assertDatabaseHas('carts', [//入力確認
                'user_id' => $user->id,
                'product_id' => $product->id,
                'count' => 2
            ]);
        }

        $response = $this->actingAs($user)
            ->post('/cart/minus/',[
                'product_id' => $products[0]->id,
            ]);

        $this->assertDatabaseHas('carts', [//商品がカートから減っているか
            'user_id' => $user->id,
            'product_id' => $products[0]->id,
            'count' => 1
        ]);

        $this->assertDatabaseHas('carts', [//減らしていない商品の個数は変わっていないか
            'user_id' => $user->id,
            'product_id' => $products[1]->id,
            'count' => 2
        ]);

        $sum_price = 0;
        $count = [1,2];

        foreach ($products as $key => $product) {
            if($product->genre_id === 1){
                $sum_price += $product->price * $count[$key] * 1.08;
            }else{
                $sum_price += $product->price * $count[$key] * 1.1;
            }
        }

        $response->assertJson([//返り値の確認
            'cart_goods' =>[
            [
                'count' => 2,
                'product' => [
                    'id' => $products[1]->id,
                ]
            ],
            [
                'count' => 1,
                'product' => [
                    'id' => $products[0]->id,
                ],
            ]],
            'sum_price' => (int)floor($sum_price),
        ]);

        //マイナスで0になった時の動作検証
        $response = $this->actingAs($user)
            ->post('/cart/minus/',[
                'product_id' => $products[0]->id,
            ]);

        $this->assertDatabaseMissing('carts', [//商品がカートからなくなっているか
            'user_id' => $user->id,
            'product_id' => $products[0]->id,
        ]);

        $this->assertDatabaseHas('carts', [//減らしていない商品の個数は変わっていないか
            'user_id' => $user->id,
            'product_id' => $products[1]->id,
            'count' => 2
        ]);

        if($products[1]->genre_id === 1){
            $sum_price = $products[1]->price * 2 * 1.08;
        }else{
            $sum_price = $products[1]->price * 2 * 1.1;
        }

        $response->assertJson([//返り値の確認
            'cart_goods' =>[[
                'count' => 2,
                'product' => [
                    'id' => $products[1]->id,
                ]
            ]],
            'sum_price' => (int)floor($sum_price),
        ]);

        $response->assertJsonMissing([//削除した商品は返されていないか
            'cart_goods' =>[[
                'product' => [
                    'id' =>$products[0]->id,
                ]
            ]],
        ]);
    }

    public function testCanAddToNotAuthCart()//未ログイン時にカートから商品を減らせるかどうか
    {
        $this->seed('BaseSeeder');//戻す
        $products = factory(Product::class,2)->create();
        $cookie_str = '';
        foreach ($products as $product) {
            for ($i=0; $i < 2; $i++) {
                $cookie_str .= $product->id.',';
            }
        }

        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->post('/cart/minus/',[
                'product_id' => $products[0]->id,
            ]);

        $expected_cookie_str = '';

        $expected_cookie_str .= $products[0]->id.',';
        for ($i=0; $i < 2; $i++) {
            $expected_cookie_str .= $products[1]->id.',';
        }

        $response->assertCookie('cart_product_ids',$expected_cookie_str);//Cookieの値から商品が減っているか

        $count = [1,2];
        $sum_price = 0;

        foreach ($products as $key => $product) {
            if($product->genre_id === 1){
                $sum_price += $product->price * $count[$key] * 1.08;
            }else{
                $sum_price += $product->price * $count[$key] * 1.1;
            }
        }

        $response->assertJson([//返り値の確認
            'products' => [
                [
                    'id' => $products[1]->id,
                ],
                [
                    'id' => $products[0]->id,
                ],
            ],
            'product_count' => [
                '0' => 2,
                '1' => 1,
            ],
            'sum_price' => (int)floor($sum_price),
        ]);

        //マイナスで0になった時の動作検証
        $response = $this->withCookies(['cart_product_ids' => $expected_cookie_str])
            ->post('/cart/minus/',[
                'product_id' => $products[0]->id,
            ]);

        $expected_cookie_str = '';

        for ($i=0; $i < 2; $i++) {
            $expected_cookie_str .= $products[1]->id.',';
        }

        $response->assertCookie('cart_product_ids',$expected_cookie_str);//Cookieの値から商品がなくなっているか

        if($products[1]->genre_id === 1){
            $sum_price = $products[1]->price * 2 * 1.08;
        }else{
            $sum_price = $products[1]->price * 2 * 1.1;
        }

        $response->assertJson([//返り値の確認
            'products' =>[
                [
                'id' => $products[1]->id,
                ]
            ],
            'product_count' => [
                '0' => 2,
            ],
            'sum_price' => (int)floor($sum_price),
        ]);
    }
}
