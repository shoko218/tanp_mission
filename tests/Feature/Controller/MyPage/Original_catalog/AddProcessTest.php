<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPost()//データを登録できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();
        $product = factory(Product::class)->create();

        $infos =[
            'catalog_id' => $catalog->id,
            'product_id' => $product->id,
        ];

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/add_process',$infos);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
                ->assertSessionHas('suc_msg','追加しました。');

        $this->assertDatabaseHas('catalog_product',$infos);
    }

    public function testCanShowError()//エラーが発生している旨を表示できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();
        $products = factory(Product::class,5)->create();

        $infos =[
            'catalog_id' => $catalog->id,
            'product_id' => $products[0]->id,
        ];

        //既に同じ商品がカタログに入っているエラー
        $this->actingAs($user)
            ->post('/mypage/original_catalog/add_process',$infos);

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/add_process',$infos);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
                ->assertSessionHas('err_msg','その商品は既にこのカタログに追加されています。');

        //既に中身を確定しているエラー
        $catalog->did_send_mail = true;
        $catalog->save();

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/add_process',$infos);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
                ->assertSessionHas('err_msg','そのカタログは既に中身を確定しています。');
    }
}
