<?php

namespace Tests\Feature\Controller\Main\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Model\Cart;
use App\Model\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CartPlusTest extends TestCase
{
    use DatabaseMigrations;
    //scenesテーブルのidに依存しているため、ここではDatabaseMigrationsを使用

    public function testCanMinusCart()//ログイン時にカートから商品を増やせるかどうか
    {
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $products = factory(Product::class,2)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'count' => 254
            ]);
            $this->assertDatabaseHas('carts', [//入力確認
                'user_id' => $user->id,
                'product_id' => $product->id,
                'count' => 254
            ]);
        }

        $response = $this->actingAs($user)
            ->post('/cart/plus/',[
                'product_id' => $products[0]->id,
            ]);

        $this->assertDatabaseHas('carts', [//カート内の商品が増えているか
            'user_id' => $user->id,
            'product_id' => $products[0]->id,
            'count' => 255
        ]);

        $this->assertDatabaseHas('carts', [//増やしていない商品の個数は変わっていないか
            'user_id' => $user->id,
            'product_id' => $products[1]->id,
            'count' => 254
        ]);

        $sum_price = 0;
        $count = [255,254];

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
                    'count' => 254,
                    'product' => [
                        'id' =>$products[1]->id,
                    ]
                ],
                [
                    'count' => 255,
                    'product' => [
                        'id' =>$products[0]->id,
                    ],
                ]
            ],
            'sum_price' => (int)floor($sum_price),
        ]);

        //プラスで最大値を超えた時の動作検証
        $response = $this->actingAs($user)
            ->post('/cart/plus/',[
                'product_id' => $products[0]->id,
            ]);

        $this->assertDatabaseHas('carts', [//商品が増えていないか
            'user_id' => $user->id,
            'product_id' => $products[0]->id,
            'count' => 255
        ]);

        $this->assertDatabaseHas('carts', [//増やしていない商品の個数は変わっていないか
            'user_id' => $user->id,
            'product_id' => $products[1]->id,
            'count' => 254
        ]);

        $response->assertJson([//返り値の確認
            'cart_goods' =>[
                [
                    'count' => 254,
                    'product' => [
                        'id' =>$products[1]->id,
                    ]
                ],
                [
                    'count' => 255,
                    'product' => [
                        'id' =>$products[0]->id,
                    ],
                ]
            ],
            'sum_price' => (int)floor($sum_price),
        ]);
    }

    public function testCanAddToNotAuthCart()//未ログイン時にカートから商品を増やせるかどうか
    {
        $this->seed('BaseSeeder');//戻す
        $products = factory(Product::class,2)->create();
        $cookie_str = '';
        foreach ($products as $product) {
            for ($i=0; $i < 254; $i++) {
                $cookie_str .= $product->id.',';
            }
        }

        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->post('/cart/plus/',[
                'product_id' => $products[0]->id,
            ]);

        $expected_cookie_str = '';

        for ($i=0; $i < 254; $i++) {
            $expected_cookie_str .= $products[0]->id.',';
        }
        for ($i=0; $i < 254; $i++) {
            $expected_cookie_str .= $products[1]->id.',';
        }
        $expected_cookie_str .= $products[0]->id.',';

        $response->assertCookie('cart_product_ids',$expected_cookie_str);//Cookieの値から商品が減っているか

        $count = [255,254];
        $sum_price = 0;

        foreach ($products as $key => $product) {
            if($product->genre_id === 1){
                $sum_price += $product->price * $count[$key] * 1.08;
            }else{
                $sum_price += $product->price * $count[$key] * 1.1;
            }
        }

        $response->assertJson([//返り値の確認
            'products' =>[
                [
                    'id' =>$products[1]->id,
                ],
                [
                    'id' =>$products[0]->id,
                ],
            ],
            'product_count' => [
                '0' => 254,
                '1' => 255,
            ],
            'sum_price' => (int)floor($sum_price),
        ]);

        //プラスで最大値を超えた時の動作検証
        $response = $this->withCookies(['cart_product_ids' => $expected_cookie_str])
            ->post('/cart/plus/',[
                'product_id' => $products[0]->id,
            ]);

        $response->assertCookie('cart_product_ids',$expected_cookie_str);//Cookieの値が増えていないか

        $response->assertJson([//返り値の確認
            'products' =>[
                [
                'id' =>$products[1]->id,
                ],
                [
                'id' =>$products[0]->id,
                ],
            ],
            'product_count' => [
                '0' => 254,
                '1' => 255,
            ],
            'sum_price' => (int)floor($sum_price),
        ]);
    }
}
