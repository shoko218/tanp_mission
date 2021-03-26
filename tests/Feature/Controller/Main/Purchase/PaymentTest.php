<?php

namespace Tests\Feature\Controller\Main\Purchase;

use App\Model\Cart;
use App\Model\Lover;
use App\Model\Prefecture;
use App\Model\Product;
use App\Model\Relationship;
use App\Model\Scene;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use DatabaseMigrations;
    //scenesテーブルのidに依存しているため、ここではDatabaseMigrationsを使用
    use WithFaker;

    public function testCanGet()//アクセスできるかどうか
    {
        $this->seed('BaseSeeder');//戻す
        //ログイン前
        $infos =[
            'forwarding_last_name' => $this->faker->lastName,
            'forwarding_first_name' => $this->faker->firstName,
            'forwarding_last_name_furigana' => $this->faker->lastKanaName,
            'forwarding_first_name_furigana' => $this->faker->firstKanaName,
            'forwarding_postal_code' => $this->faker->postcode,
            'forwarding_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'forwarding_address' => $this->faker->city.$this->faker->streetAddress,
            'forwarding_telephone' => str_replace('-','',$this->faker->phoneNumber),
            'gender' => $this->faker->numberBetween(0, 2),
            'relationship_id' => Relationship::inRandomOrder()->first()->id,
            'age' => $this->faker->numberBetween(0, 100),
            'scene_id' => Scene::inRandomOrder()->first()->id,
            'user_last_name' => $this->faker->lastName,
            'user_first_name' => $this->faker->firstName,
            'user_last_name_furigana' => $this->faker->lastKanaName,
            'user_first_name_furigana' => $this->faker->firstKanaName,
            'user_postal_code' => $this->faker->postcode,
            'user_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'user_address' => $this->faker->city.$this->faker->streetAddress,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_telephone' => str_replace('-','',$this->faker->phoneNumber),
        ];

        $products = factory(Product::class, 5)->create();
        $cookie_str = '';
        $sum_price = 0.0;
        foreach ($products as $product) {
            $cookie_str .= $product->id.',';
            if($product->genre_id === 1){
                $sum_price += $product->price * 1.08;
            }else{
                $sum_price += $product->price * 1.1;
            }
        }

        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->withSession($infos)
            ->get('/purchase/payment');

        $response->assertOk();

        //ログイン後
        $user = factory(User::class)->create();
        $products = factory(Product::class,5)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $infos =[
            'forwarding_last_name' => $this->faker->lastName,
            'forwarding_first_name' => $this->faker->firstName,
            'forwarding_last_name_furigana' => $this->faker->lastKanaName,
            'forwarding_first_name_furigana' => $this->faker->firstKanaName,
            'forwarding_postal_code' => $this->faker->postcode,
            'forwarding_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'forwarding_address' => $this->faker->city.$this->faker->streetAddress,
            'forwarding_telephone' => str_replace('-','',$this->faker->phoneNumber),
            'gender' => $this->faker->numberBetween(0, 2),
            'relationship_id' => Relationship::inRandomOrder()->first()->id,
            'age' => $this->faker->numberBetween(0, 100),
            'scene_id' => Scene::inRandomOrder()->first()->id,
            'lover_id' => $lover->id,
            'user_last_name' => $this->faker->lastName,
            'user_first_name' => $this->faker->firstName,
            'user_last_name_furigana' => $this->faker->lastKanaName,
            'user_first_name_furigana' => $this->faker->firstKanaName,
            'user_postal_code' => $this->faker->postcode,
            'user_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'user_address' => $this->faker->city.$this->faker->streetAddress,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_telephone' => str_replace('-','',$this->faker->phoneNumber),
        ];

        $sum_price = 0.0;
        foreach ($products as $product) {
            if($product->genre_id === 1){
                $sum_price += $product->price * 1.08;
            }else{
                $sum_price += $product->price * 1.1;
            }
        }

        $response = $this->actingAs($user)
            ->withSession($infos)
            ->get('/purchase/payment');

        $response->assertOk();
    }

    public function testCanSeeContents()//ページの内容が表示されているかどうか
    {
        $this->seed('BaseSeeder');//戻す
        //ログイン前
        $infos =[
            'forwarding_last_name' => $this->faker->lastName,
            'forwarding_first_name' => $this->faker->firstName,
            'forwarding_last_name_furigana' => $this->faker->lastKanaName,
            'forwarding_first_name_furigana' => $this->faker->firstKanaName,
            'forwarding_postal_code' => $this->faker->postcode,
            'forwarding_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'forwarding_address' => $this->faker->city.$this->faker->streetAddress,
            'forwarding_telephone' => str_replace('-','',$this->faker->phoneNumber),
            'gender' => $this->faker->numberBetween(0, 2),
            'relationship_id' => Relationship::inRandomOrder()->first()->id,
            'age' => $this->faker->numberBetween(0, 100),
            'scene_id' => Scene::inRandomOrder()->first()->id,
            'user_last_name' => $this->faker->lastName,
            'user_first_name' => $this->faker->firstName,
            'user_last_name_furigana' => $this->faker->lastKanaName,
            'user_first_name_furigana' => $this->faker->firstKanaName,
            'user_postal_code' => $this->faker->postcode,
            'user_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'user_address' => $this->faker->city.$this->faker->streetAddress,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_telephone' => str_replace('-','',$this->faker->phoneNumber),
        ];

        $products = factory(Product::class, 5)->create();
        $cookie_str = '';
        $sum_price = 0.0;
        foreach ($products as $product) {
            $cookie_str .= $product->id.',';
            if($product->genre_id === 1){
                $sum_price += $product->price * 1.08;
            }else{
                $sum_price += $product->price * 1.1;
            }
        }

        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->withSession($infos)
            ->get('/purchase/payment');

        $response->assertSee('<p class="cart_sum">商品合計:<b>¥'.number_format((int)floor($sum_price)).'</b></p>');

        foreach ($products as $product) {//カートの中身が反映されているか
            $response->assertSee('<p class="rc_title">'.$product->name.'</p>');
        }

        //ログイン後
        $user = factory(User::class)->create();
        $products = factory(Product::class,5)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $infos =[
            'forwarding_last_name' => $this->faker->lastName,
            'forwarding_first_name' => $this->faker->firstName,
            'forwarding_last_name_furigana' => $this->faker->lastKanaName,
            'forwarding_first_name_furigana' => $this->faker->firstKanaName,
            'forwarding_postal_code' => $this->faker->postcode,
            'forwarding_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'forwarding_address' => $this->faker->city.$this->faker->streetAddress,
            'forwarding_telephone' => str_replace('-','',$this->faker->phoneNumber),
            'gender' => $this->faker->numberBetween(0, 2),
            'relationship_id' => Relationship::inRandomOrder()->first()->id,
            'age' => $this->faker->numberBetween(0, 100),
            'scene_id' => Scene::inRandomOrder()->first()->id,
            'lover_id' => $lover->id,
            'user_last_name' => $this->faker->lastName,
            'user_first_name' => $this->faker->firstName,
            'user_last_name_furigana' => $this->faker->lastKanaName,
            'user_first_name_furigana' => $this->faker->firstKanaName,
            'user_postal_code' => $this->faker->postcode,
            'user_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'user_address' => $this->faker->city.$this->faker->streetAddress,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_telephone' => str_replace('-','',$this->faker->phoneNumber),
        ];

        $sum_price = 0.0;
        foreach ($products as $product) {
            if($product->genre_id === 1){
                $sum_price += $product->price * 1.08;
            }else{
                $sum_price += $product->price * 1.1;
            }
        }

        $response = $this->actingAs($user)
            ->withSession($infos)
            ->get('/purchase/payment');

        $response->assertSee('<p class="cart_sum">商品合計:<b>¥'.number_format((int)floor($sum_price)).'</b></p>');//合計金額が合っているか

        foreach ($products as $product) {//カートの中身が反映されているか
            $response->assertSee('<p class="rc_title">'.$product->name.'</p>');
        }
    }

    public function testCanRedirectIfCartIsEmpty(){//カートの中身がなかったときにカート画面にリダイレクトするか

        $this->seed('BaseSeeder');//戻す
        $infos =[
            'forwarding_last_name' => $this->faker->lastName,
            'forwarding_first_name' => $this->faker->firstName,
            'forwarding_last_name_furigana' => $this->faker->lastKanaName,
            'forwarding_first_name_furigana' => $this->faker->firstKanaName,
            'forwarding_postal_code' => $this->faker->postcode,
            'forwarding_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'forwarding_address' => $this->faker->city.$this->faker->streetAddress,
            'forwarding_telephone' => str_replace('-','',$this->faker->phoneNumber),
            'gender' => $this->faker->numberBetween(0, 2),
            'relationship_id' => Relationship::inRandomOrder()->first()->id,
            'age' => $this->faker->numberBetween(0, 100),
            'scene_id' => Scene::inRandomOrder()->first()->id,
            'user_last_name' => $this->faker->lastName,
            'user_first_name' => $this->faker->firstName,
            'user_last_name_furigana' => $this->faker->lastKanaName,
            'user_first_name_furigana' => $this->faker->firstKanaName,
            'user_postal_code' => $this->faker->postcode,
            'user_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'user_address' => $this->faker->city.$this->faker->streetAddress,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_telephone' => str_replace('-','',$this->faker->phoneNumber),
        ];

        //ログイン×、DBカート×、クッキーカート×
        $response = $this->withSession($infos)
            ->get('/purchase/payment');
        $response->assertRedirect('/cart');

        //ログイン○、DBカート×、クッキーカート×
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->withSession($infos)
            ->get('/purchase/payment');
        $response->assertRedirect('/cart');

        //ログイン○、DBカート×、クッキーカート○
        $products = factory(Product::class, 5)->create();
        $cookie_str = '';
        foreach ($products as $product) {
            $cookie_str .= $product->id.',';
        }
        $response = $this->actingAs($user)
            ->withCookies(['cart_product_ids' => $cookie_str])
            ->withSession($infos)
            ->get('/purchase/payment');
        $response->assertRedirect('/cart');
    }
}
