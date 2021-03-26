<?php

namespace Tests\Feature\Controller\Main\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Model\Cart;
use App\Model\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CartCompleteOutTest extends TestCase
{
    use DatabaseMigrations;
    //scenesテーブルのidに依存しているため、ここではDatabaseMigrationsを使用

    public function testCanCompletelyRemoveFromAuthCart()//ログイン時にカートから商品を全て取り除けるかどうか
    {
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $products = factory(Product::class,2)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'count' => 9
            ]);
            $this->assertDatabaseHas('carts', [//入力確認
                'user_id' => $user->id,
                'product_id' => $product->id,
                'count' => 9
            ]);
        }

        $response = $this->actingAs($user)//カートから削除
            ->post('/cart/complete_out/',[
                'product_id' => $products[0]->id,
            ]);

        $this->assertDatabaseMissing('carts', [//削除した商品がカートから無くなっているか
            'user_id' => $user->id,
            'product_id' => $products[0]->id,
        ]);

        $this->assertDatabaseHas('carts', [//削除していない商品はカートの中にあるか
            'user_id' => $user->id,
            'product_id' => $products[1]->id,
            'count' => 9
        ]);

        if($products[1]->genre_id === 1){
            $sum_price = $products[1]->price * 9 * 1.08;
        }else{
            $sum_price = $products[1]->price * 9 * 1.1;
        }

        $response->assertJson([//返り値の確認
            'cart_goods' =>[[
                'count' => 9,
                'product' => [
                    'id' =>$products[1]->id,
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

    public function testCanCompletelyRemoveFromNotAuthCart()//未ログイン時にカートから商品を削除できるかどうか
    {
        $this->seed('BaseSeeder');//戻す
        $products = factory(Product::class,2)->create();
        $cookie_str = '';
        foreach ($products as $product) {
            for ($i=0; $i < 9; $i++) {
                $cookie_str .= $product->id.',';
            }
        }
        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->post('/cart/complete_out/',[
                'product_id' => $products[0]->id,
            ]);

        $expected_cookie_str = '';
        for ($i=0; $i < 9; $i++) {
            $expected_cookie_str .= $products[1]->id.',';
        }

        $response->assertCookie('cart_product_ids',$expected_cookie_str);//Cookieの値から削除した商品がなくなっているか

        if($products[1]->genre_id === 1){
            $sum_price = (int)floor($products[1]->price * 9 * 1.08);
        }else{
            $sum_price = (int)floor($products[1]->price * 9 * 1.1);
        }

        $response->assertJson([//返り値の確認
            'products' =>[
                [
                    'id' =>$products[1]->id,
                ]
            ],
            'product_count' => [
                '0' => 9,
            ],
            'sum_price' => $sum_price,
        ]);

        $response->assertJsonMissing([//削除した商品は返されていないか
            'products' =>[[
                'id' =>$products[0]->id,
            ]],
        ]);
    }
}
