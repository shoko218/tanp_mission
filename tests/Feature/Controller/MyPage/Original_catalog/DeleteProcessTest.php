<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Model\CatalogProduct;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPost()//カタログを削除できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/delete_process',[
                'catalog_id' => $catalog->id,
            ]);

        $response->assertRedirect('/mypage/original_catalog/')
                ->assertSessionHas('suc_msg','削除しました。');

        $this->assertDatabaseMissing('catalog_product',[
                'catalog_id' => $catalog->id,
            ]);
    }

    public function testCanShowError()//エラーが発生している旨を表示できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();

        //存在しないカタログidが指定されていたらエラー
        $infos =[
            'catalog_id' => $catalog->id,
        ];

        $catalog->delete();

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/delete_process',[
                'catalog_id' => $catalog->id,
            ]);

        $response->assertRedirect('/mypage/original_catalog/')
                ->assertSessionHas('err_msg','エラーが発生しました。');

        //既に相手に送っているカタログならエラー
        $catalog = factory(Catalog::class)->create();
        factory(CatalogProduct::class,2)->create([
            'catalog_id' => $catalog->id,
        ]);

        $catalog->did_send_mail = true;
        $catalog->save();

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/delete_process',[
                'catalog_id' => $catalog->id,
            ]);

        $response->assertRedirect('/mypage/original_catalog/')
                ->assertSessionHas('err_msg','既に相手に送っているカタログは削除できません。');

        $this->assertDatabaseHas('catalog_product',[
                'catalog_id' => $catalog->id,
            ]);
    }
}
