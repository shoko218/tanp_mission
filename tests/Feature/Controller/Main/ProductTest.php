<?php

namespace Tests\Feature\Controller\Main;

use App\Model\Favorite;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet()//アクセスできるか
    {
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        $response = $this->get('/product?id='.$product->id);
        $response->assertOk();
    }

    public function testCanSeeContents(){ //コンテンツが見えているか
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        $response = $this->get('/product?id='.$product->id);
        $response->assertSeeText($product->name)
            ->assertSeeText('カートに入れる');
    }

    public function testCanDistinctionAuth(){//ログインの見分けがついているか
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        $response = $this->get('/product?id='.$product->id);
        $response->assertDontSee('good-component')
            ->assertDontSee('onclick="location.href=\'/mypage/original_catalog/select_which_catalog/'.$product->id);//ログイン前

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/product?id='.$product->id);
        $response->assertSee('good-component')
            ->assertSee('onclick="location.href=\'/mypage/original_catalog/select_which_catalog/'.$product->id);//ログイン前
    }

    public function testCanGetFavorite(){//いいねを取得できているか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)
            ->get('/product?id='.$product->id);
        $response->assertSee(':is-fav=\'false\'');

        factory(Favorite::class)->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/product?id='.$product->id);
        $response->assertSee(':is-fav=\'true\'');
    }
}
