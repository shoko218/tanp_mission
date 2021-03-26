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
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentProcessTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;
    //productsテーブルのidに依存しているため、ここではDatabaseMigrationsを使用

    public function testCanPost()//処理ができるかどうか
    {
        $charge_mock = Mockery::mock('overload:\Stripe\Charge');
        $charge_mock->shouldReceive('create')
            ->andReturn(true);

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
        foreach ($products as $product) {
            $cookie_str .= $product->id.',';
        }

        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->withSession($infos)
            ->post('/purchase/payment_process',[
                'stripeToken' => 'Test',
            ]);
        $response->assertRedirect('/msg')
            ->assertSessionHas('title', '購入完了')
            ->assertSessionHas('msg', '購入が完了しました。');

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

        $response = $this->actingAs($user)
            ->withSession($infos)
            ->post('/purchase/payment_process',[
                'stripeToken' => 'Test',
            ]);

        $response->assertRedirect('/msg')
            ->assertSessionHas('title', '購入完了')
            ->assertSessionHas('msg', '購入が完了しました。');
    }

    public function testCanRedirectIfCartIsEmpty()//カートの中身がなかったときにカート画面にリダイレクトするか
    {
        $charge_mock = Mockery::mock('overload:\Stripe\Charge');
        $charge_mock->shouldReceive('create')
            ->andReturn(true);

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
