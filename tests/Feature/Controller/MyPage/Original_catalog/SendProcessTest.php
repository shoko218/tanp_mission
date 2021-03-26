<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Model\CatalogProduct;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPost()//データを登録できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();
        $catalog_products = factory(CatalogProduct::class,2)->create([
            'catalog_id' => $catalog->id,
        ]);

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/send_process',[
                'catalog_id' => $catalog->id
            ]);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
                ->assertSessionHas('suc_msg','送信しました。');
    }

    public function testCanShowError()//エラーが発生している旨を表示できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();
        factory(CatalogProduct::class)->create([
            'catalog_id' => $catalog->id,
        ]);

        //カタログに登録した商品数が2つ未満のエラー
        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/send_process',[
                'catalog_id' => $catalog->id
            ]);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
                ->assertSessionHas('err_msg','カタログを送信できるのは商品を二つ以上登録してからです。');

        //既にメールを送っているエラー
        factory(CatalogProduct::class)->create([
            'catalog_id' => $catalog->id,
        ]);

        $catalog->did_send_mail = true;
        $catalog->save();

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/send_process',[
                'catalog_id' => $catalog->id
            ]);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
                ->assertSessionHas('err_msg','既にカタログを送信しています。');
    }
}
