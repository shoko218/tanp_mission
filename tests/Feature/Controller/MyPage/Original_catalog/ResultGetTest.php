<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Model\CatalogProduct;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResultGetTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGetTrueResult()
    {
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $products = factory(Product::class,2)->create();
        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/result_get',[
                'kind' => 2
            ]);

        $response->assertJson([//返り値が空か確認
            'results' =>[],
        ]);

        $replied_catalogs = factory(Catalog::class,2)->create([//返答されたカタログを作成
            'user_id' => $user->id,
            'did_send_mail' => true,
        ]);

        foreach ($replied_catalogs as $replied_catalog) {
            foreach ($products as $product) {
                factory(CatalogProduct::class)->create([
                    'catalog_id' => $replied_catalog->id,
                    'product_id' => $product->id,
                ]);
            }
            $replied_catalog->selected_id = $products[0]->id;
            $replied_catalog->save();
        }

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/result_get',[
                'kind' => 2
            ]);

        foreach ($replied_catalogs as $replied_catalog) {
            $expected_json['results'][] = [
                'id' => $replied_catalog->id,
                'user_id' => $replied_catalog->user_id,
                'name' => $replied_catalog->name,
                'email' => $replied_catalog->email,
                'url_str' => $replied_catalog->url_str,
                'created_at' => $replied_catalog->created_at,
                'updated_at' => $replied_catalog->updated_at,
                'img_num' => $replied_catalog->img_num,
                'did_check_reply' => $replied_catalog->did_check_reply,
                'selected_id' => $replied_catalog->selected_id,
                'did_send_mail' => $replied_catalog->did_send_mail
            ];
        }

        $response->assertJson($expected_json);//返り値が正しいか確認

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/result_get',[
                'kind' => 0
            ]);

        $response->assertJsonMissing($expected_json);//返り値が正しいか確認
    }


    public function testCanShowError()//エラー(存在しない種別が選択されている)を検知し、表示できるか
    {
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/result_get',[
                'kind' => 4
            ]);

        $response->assertRedirect('/msg')
            ->assertSessionHas('title','エラー')
            ->assertSessionHas('msg','エラーが発生しました。');
    }
}
