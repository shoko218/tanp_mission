<?php

namespace Tests\Feature\Controller\Main\Cart;

use App\Model\Cart;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CartTest extends TestCase
{
    use DatabaseMigrations;
    //scenesテーブルのidに依存しているため、ここではDatabaseMigrationsを使用

    public function testCanGet()//アクセスできるか
    {
        $this->seed('BaseSeeder');
        $response = $this->get('/cart');//ログイン前
        $response->assertOk()
            ->assertSeeText('お買い物カゴ')
            ->assertSeeText('まだ商品はありません。')
            ->assertSeeText('商品を探しに行く');

        $user = factory(User::class)->create();//ログイン後
        $response = $this->actingAs($user)
            ->get('/cart');
        $response->assertOk()
            ->assertSeeText('お買い物カゴ')
            ->assertSeeText('まだ商品はありません。')
            ->assertSeeText('商品を探しに行く');
    }

    public function testCanGetAuthCart(){//ログイン時にカートがきちんと動作するか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        factory(Product::class,20)->create();
        factory(Cart::class,5)->create([
            'user_id' => $user->id,
        ]);

        $carts = Cart::select('*')
            ->where('user_id',$user->id)
            ->get();

        $sum_price = 0.0;
        foreach ($carts as $cart) {
            if ($cart->product->genre_id==1) {//食品(軽減税率8％)
                $sum_price += $cart->product->price*$cart->count*1.08;
            }else{//その他(税率10%)
                $sum_price += $cart->product->price*$cart->count*1.1;
            }
        }

        $response = $this->actingAs($user)
            ->get('/cart');
        $response->assertOk()
            ->assertSeeText('お買い物カゴ')
            ->assertSee(":sum-price='".floor($sum_price)."'");
        foreach ($carts as $cart) {
            $response->assertSee('"name":"'.$cart->product->name.'"');
        }

    }

    public function testCanGetNotAuthCart(){//非ログイン時にカートがきちんと動作するか
        $this->seed('BaseSeeder');
        $products = factory(Product::class,5)->create();
        $cookie_str = '';
        foreach ($products as $product) {
            $cookie_str .= $product->id.',';
        }

        $sum_price=0.0;
        foreach ($products as $product) {
            if($product->genre_id==1){//食品(軽減税率8％)
                $sum_price+=$product->price*1.08;
            }else{//その他(税率10%)
                $sum_price+=$product->price*1.1;
            }
        }

        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->get('/cart');
        $response->assertOk()
            ->assertSeeText('お買い物カゴ')
            ->assertSee(":sum-price='".floor($sum_price)."'");
        foreach ($products as $product) {
            $response->assertSee('"name":"'.$product->name.'"');
        }
    }
}
