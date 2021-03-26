<?php

namespace Tests\Feature\Controller\MyPage;

use App\Model\Favorite;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        factory(Favorite::class,20)->create([
            'user_id' => $user->id,
        ]);

        $favorite_products = Product::join('favorites','products.id','=','product_id')
        ->select(DB::raw('products.*'))
        ->where('favorites.user_id','=',$user->id)
        ->orderBy('favorites.id','desc')
        ->limit(12)
        ->get();

        $response = $this->actingAs($user)
            ->get('/mypage/favorite');

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が表示されているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        factory(Favorite::class,20)->create([
            'user_id' => $user->id,
        ]);

        $favorite_products = Product::join('favorites','products.id','=','product_id')
        ->select(DB::raw('products.*'))
        ->where('favorites.user_id','=',$user->id)
        ->orderBy('favorites.id','desc')
        ->limit(12)
        ->get();

        $response = $this->actingAs($user)
            ->get('/mypage/favorite');

        foreach ($favorite_products as $favorite_product) {
            $response->assertSee('<p class="rc_title">'.$favorite_product->name.'</p>')
            ->assertSee('<p class="rc_genre">'.$favorite_product->genre->name.'</p>')
            ->assertSee('<p class="rc_price">¥'.number_format($favorite_product->price).'(+tax)</p>');
        }
    }

    public function testCanShowNoHistory(){//お気に入りがない時にその旨を表示できているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/favorite');
        $response->assertSee('<p class="nothing_msg">まだ商品はありません。</p>');
    }
}
