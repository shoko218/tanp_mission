<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Model\CatalogProduct;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemoveProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPost()//商品を削除できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();
        $product = factory(Product::class)->create();
        factory(CatalogProduct::class)->create([
            'catalog_id' => $catalog->id,
            'product_id' => $product->id,
        ]);

        $infos =[
            'catalog_id' => $catalog->id,
            'product_id' => $product->id,
        ];

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/remove_process',$infos);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
                ->assertSessionHas('suc_msg','削除しました。');

        $this->assertDatabaseMissing('catalog_product',$infos);
    }

    public function testCanShowError()//エラーが発生している旨を表示できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();
        $product = factory(Product::class)->create();

        //カタログに登録されていない商品が指定されていたらエラー
        $infos =[
            'catalog_id' => $catalog->id,
            'product_id' => $product->id,
        ];

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/remove_process',$infos);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
            ->assertSessionHas('err_msg','エラーが発生しました。');

        //既に相手に送っているカタログならエラー
        factory(CatalogProduct::class)->create([
            'catalog_id' => $catalog->id,
            'product_id' => $product->id,
        ]);
        factory(CatalogProduct::class)->create([
            'catalog_id' => $catalog->id,
        ]);

        $catalog->did_send_mail = true;
        $catalog->save();

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/remove_process',$infos);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
            ->assertSessionHas('err_msg','既に相手に送信しているカタログは編集できません。');

        $this->assertDatabaseHas('catalog_product',$infos);
    }
}
