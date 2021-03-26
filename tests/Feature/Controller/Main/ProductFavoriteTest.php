<?php

namespace Tests\Feature\Controller\Main;

use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductFavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPost()//POSTできるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $response = $this->actingAs($user)
            ->post('/product/favorite', [
                'product_id' => $product->id,
            ]);
        $response->assertOk();
    }

    public function testCanDistinctionAuth(){//ログインの見分けがついているか
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        $response = $this->post('/product/favorite', [
                'product_id' => $product->id,
            ]);
        $response->assertredirect('/login');
    }

    public function testCanFavorite()//いいね/いいね解除できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        //初期状態
        $response = $this->actingAs($user)
            ->get('/product?id='.$product->id);
        $response->assertSee(':is-fav=\'false\'');

        //いいね
        $response = $this->actingAs($user)
        ->post('/product/favorite', [
            'product_id' => $product->id,
            ]);
        $response = $this->actingAs($user)
            ->get('/product?id='.$product->id);
        $response->assertSee(':is-fav=\'true\'');

        //いいね解除
        $response = $this->actingAs($user)
        ->post('/product/favorite', [
            'product_id' => $product->id,
            ]);
        $response = $this->actingAs($user)
            ->get('/product?id='.$product->id);
        $response->assertSee(':is-fav=\'false\'');
    }
}
