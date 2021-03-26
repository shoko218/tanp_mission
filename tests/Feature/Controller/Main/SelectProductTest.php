<?php

namespace Tests\Feature\Controller\Main;

use App\Model\Catalog;
use App\Model\CatalogProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SelectProductTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet()//アクセスできるか
    {
        $this->seed('BaseSeeder');//戻す
        $catalog = factory(Catalog::class)->create(['did_send_mail' => true]);
        $catalog_product = factory(CatalogProduct::class,2)->create(['catalog_id' => $catalog->id]);
        $response = $this->get('/select_product/'.$catalog->url_str);
        $response->assertOk();
    }

    public function testCanShowAlreadySelectedMsg()//既に選択されている旨のメッセージを表示できるか
    {
        $this->seed('BaseSeeder');//戻す
        $catalog = factory(Catalog::class)->create(['did_send_mail' => true]);
        $catalog_product = factory(CatalogProduct::class,2)->create(['catalog_id' => $catalog->id]);
        $catalog->selected_id = $catalog_product[0]->product_id;
        $catalog->save();
        $response = $this->get('/select_product/'.$catalog->url_str);
        $response->assertRedirect('/msg')
            ->assertSessionHas('title', '選択済み')
            ->assertSessionHas('msg','既に商品が選択されています。');
    }

    public function testCanShowCatalogHasNotBeenSubmittedYet()//無効なURLである(カタログがまだ送信されてない)旨を表示できるか
    {
        $this->seed('BaseSeeder');
        $catalog = factory(Catalog::class)->create();
        $response = $this->get('/select_product/'.$catalog->url_str);
        $response->assertRedirect('/')
            ->assertSessionHas('err_msg','無効なURLです。');
    }

    public function testCanShowThereIsNotCatalog()//無効なURLである(カタログが存在しない)旨を表示できるか
    {
        $this->seed('BaseSeeder');
        $response = $this->get('/select_product/'.'test');
        $response->assertRedirect('/')
            ->assertSessionHas('err_msg','無効なURLです。');
    }
}
