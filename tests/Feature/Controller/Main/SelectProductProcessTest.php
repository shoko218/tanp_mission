<?php

namespace Tests\Feature\Controller\Main;

use App\Model\Catalog;
use App\Model\CatalogProduct;
use App\Model\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SelectProductProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPost()//回答を登録できるか
    {
        $this->seed('BaseSeeder');//戻す
        $catalog = factory(Catalog::class)->create(['did_send_mail' => true]);
        $catalog_products = factory(CatalogProduct::class,2)->create(['catalog_id' => $catalog->id]);
        $response = $this->post('/select_product_process/'.$catalog->url_str,[
            'product_id' => $catalog_products[0]->product_id,
        ]);
        $response->assertRedirect('/msg')
            ->assertSessionHas('title', '送信完了')
            ->assertSessionHas('msg','送信しました。');
    }

    public function testCanCheckSelectedOneIsNotInCatalog()//カタログに入っていない商品を選択した時にエラーを出せるか
    {
        $this->seed('BaseSeeder');//戻す
        $catalog = factory(Catalog::class)->create(['did_send_mail' => true]);
        $catalog_product = factory(CatalogProduct::class,2)->create(['catalog_id' => $catalog->id]);
        $product = factory(Product::class)->create();
        $response = $this->post('/select_product_process/'.$catalog->url_str,[
            'product_id' => $product->id,
        ]);
        $response->assertRedirect('/select_product/'.$catalog->url_str)
            ->assertSessionHas('err_msg','エラーが発生しました。');
    }

    public function testCanShowAlreadySelectedMsg()//既に選択されている旨のメッセージを表示できるか
    {
        $this->seed('BaseSeeder');//戻す
        $catalog = factory(Catalog::class)->create(['did_send_mail' => true]);
        $catalog_product = factory(CatalogProduct::class,2)->create(['catalog_id' => $catalog->id]);
        $catalog->selected_id = $catalog_product[0]->product_id;
        $catalog->save();
        $response = $this->post('/select_product_process/'.$catalog->url_str,[
            'product_id' => $catalog_product[0]->product_id,
        ]);
        $response->assertRedirect('/msg')
            ->assertSessionHas('title', '選択済み')
            ->assertSessionHas('msg','既に商品が選択されています。');
    }

    public function testCanShowError()//エラー(カタログが存在しない、もしくは選ばれた商品情報にエラーがある)を検知し、表示できるか
    {
        $this->seed('BaseSeeder');

        //カタログが存在せず、選ばれた商品情報にエラーがある
        $response = $this->post('/select_product_process/'.'test',[
            'product_id' => -1,
        ]);
        $response->assertRedirect('/msg')
            ->assertSessionHas('title','エラー')
            ->assertSessionHas('msg','エラーが発生しました。');

        //カタログが存在しない
        $product = factory(Product::class,2)->create();
        $response = $this->post('/select_product_process/'.'test',[
            'product_id' => $product[0]->id,
        ]);
        $response->assertRedirect('/msg')
            ->assertSessionHas('title','エラー')
            ->assertSessionHas('msg','エラーが発生しました。');

        //選ばれた商品情報にエラーがある
        $catalog = factory(Catalog::class)->create();
        $catalog_product = factory(CatalogProduct::class,2)->create(['catalog_id' => $catalog->id]);
        $response = $this->post('/select_product_process/'.'test',[
            'product_id' => -1,
        ]);
        $response->assertRedirect('/msg')
            ->assertSessionHas('title','エラー')
            ->assertSessionHas('msg','エラーが発生しました。');
    }
}
