<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SelectCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/select_which_catalog/'.$product->id);

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が表示されているか
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();
        $catalogs = factory(Catalog::class,6)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/select_which_catalog/'.$product->id);

        $response->assertSee('<h1>どのカタログに商品を追加しますか？</h1>');
        foreach ($catalogs as $catalog) {
            $response->assertSee('<img src="/image/catalog_imgs/'.sprintf('%05d', $catalog->img_num).'.jpg" alt="'.$catalog->name.'さんへのギフトカタログのイメージ画像" class="oc_img">')
                ->assertSee('<h3>'.$catalog->name.'さんへの<br>ギフトカタログ</h3>');
        }
    }

    public function testCanShowNoCatalog(){//カタログが登録されていない時にその旨を表示し、登録画面への誘導ボタンを表示できているか
        $this->seed('BaseSeeder');//戻す
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/select_which_catalog/'.$product->id);

        $response->assertSee('<h2>まだカタログはありません。</h2>')
            ->assertSee('<button onclick="location.href=\'/mypage/original_catalog/register\'">新しくカタログを作る</button>');
    }
}
