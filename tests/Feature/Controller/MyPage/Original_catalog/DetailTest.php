<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Model\CatalogProduct;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DetailTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/'.$catalog->id);

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が見えているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create([
            'user_id' => $user->id,
        ]);

        //作成中の場合
        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/'.$catalog->id);

        $response->assertSee('<p class="nothing_msg">まだ商品はありません。</p>')
            ->assertDontSee('<p class="reply">'.$catalog->name.'さんからの返信はまだ届いていません。</p>')
            ->assertDontSee('<span class="no_wrap">お好みのようです！</span>')
            ->assertDontSee('<button type="submit" form="cart_in" class="cart_btn" onclick="gtag(\'event\',\'click\', {\'event_category\': \'link\',\'event_label\': \'カタログへの回答からカートイン\'});">カートに入れる</button>')
            ->assertSee('<button onclick="location.href=\'/search\'">商品を探しに行く</button>')
            ->assertSee('<a href="/mypage/original_catalog/'.$catalog->id.'/edit">このカタログを編集する</a>')
            ->assertSee('<p class="submit_a"><a href="javascript:delete_form.submit()" onClick="return confirm(\'このカタログを削除します。\nよろしいですか？\');">このカタログを削除する</a></p>');

        $catalog_products = factory(CatalogProduct::class,5)->create([
            'catalog_id' => $catalog->id
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/'.$catalog->id);

        $response->assertSee('<button form="send_mail" onClick="return confirm(\'カタログをメールで送信します。\nカタログを送ると商品の変更はできなくなりますが、よろしいですか？\');">カタログの中身を決定し、<span class="no_wrap">カタログを送る<span></button>');

        foreach ($catalog->products as $product) {
            $response->assertSee('<a href="/product?id='.$product->id.'">')
                ->assertSee('<img src="/image/products/'.sprintf('%05d', $product->id).'.jpg" alt="'.$product->name.'" class="product_card_img">')
                ->assertSee('<p class="rc_title">'.$product->name.'</p>')
                ->assertSee('<p class="rc_genre">'.$product->genre->name.'</p>')
                ->assertSee('<p class="rc_price">¥'.number_format($product->price).'(+tax)</p>')
                ->assertSee('<form action="/mypage/original_catalog/remove_process" class="remove_product_btn remove_product_from_catalog_btn" method="POST" name="remove_product_'.$product->id.'">')
                ->assertSee('<a href="javascript:remove_product_'.$product->id.'.submit()" onClick="return confirm(\'削除します。\nよろしいですか？\');">削除</a>');
        }

        //送信後の場合
        $catalog->did_send_mail = true;
        $catalog->save();

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/'.$catalog->id);

        $response->assertDontSee('<p class="nothing_msg">まだ商品はありません。</p>')
            ->assertSee('<span class="no_wrap">'.$catalog->name.'さんからの</span><span class="no_wrap">返信は</span><span class="no_wrap">まだ届いていません。</span>')
            ->assertDontSee('<span class="no_wrap">お好みのようです！</span>')
            ->assertDontSee('<button type="submit" form="cart_in" class="cart_btn" onclick="gtag(\'event\',\'click\', {\'event_category\': \'link\',\'event_label\': \'カタログへの回答からカートイン\'});">カートに入れる</button>')
            ->assertDontSee('<button onclick="location.href=\'/search\'">商品を探しに行く</button>')
            ->assertDontSee('<a href="/mypage/original_catalog/2/edit">このカタログを編集する</a>')
            ->assertDontSee('<p class="submit_a"><a href="javascript:delete_form.submit()" onClick="return confirm(\'このカタログを削除します。\nよろしいですか？\');">このカタログを削除する</a></p>');

        foreach ($catalog->products as $product) {
            $response->assertSee('<a href="/product?id='.$product->id)
                ->assertSee('<img src="/image/products/'.sprintf('%05d', $product->id).'.jpg" alt="'.$product->name.'" class="product_card_img">')
                ->assertSee('<p class="rc_title">'.$product->name.'</p>')
                ->assertSee('<p class="rc_genre">'.$product->genre->name.'</p>')
                ->assertSee('<p class="rc_price">¥'.number_format($product->price).'(+tax)</p>')
                ->assertDontSee('<form action="/mypage/original_catalog/remove_process" class="remove_product_btn remove_product_from_catalog_btn" method="POST" name="remove_product_'.$product->id.'">')
                ->assertDontSee('<a href="javascript:remove_product_'.$product->id.'.submit()" onClick="return confirm(\'削除します。\nよろしいですか？\');">削除</a>');
        }

        //返信が来た後の場合
        $catalog->selected_id = $catalog_products[0]->product_id;
        $catalog->save();

        $selected_product = Product::find($catalog_products[0]->product_id);

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/'.$catalog->id);

        $response->assertDontSee('<p class="nothing_msg">まだ商品はありません。</p>')
            ->assertDontSee('<span class="no_wrap">'.$catalog->name.'さんからの</span><span class="no_wrap">返信は</span><span class="no_wrap">まだ届いていません。</span>')
            ->assertSee($catalog->name.'さんは<br><b>'.$selected_product->name.'</b>が<span class="no_wrap">お好みのようです！</span>')
            ->assertSee('<button type="submit" form="cart_in" class="cart_btn" onclick="gtag(\'event\',\'click\', {\'event_category\': \'link\',\'event_label\': \'カタログへの回答からカートイン\'});">カートに入れる</button>')
            ->assertDontSee('<button onclick="location.href=\'/search\'">商品を探しに行く</button>')
            ->assertDontSee('<a href="/mypage/original_catalog/2/edit">このカタログを編集する</a>')
            ->assertDontSee('<p class="submit_a"><a href="javascript:delete_form.submit()" onClick="return confirm(\'このカタログを削除します。\nよろしいですか？\');">このカタログを削除する</a></p>');

        foreach ($catalog->products as $product) {
            $response->assertSee('<a href="/product?id='.$product->id)
                ->assertSee('<img src="/image/products/'.sprintf('%05d', $product->id).'.jpg" alt="'.$product->name.'" class="product_card_img">')
                ->assertSee('<p class="rc_title">'.$product->name.'</p>')
                ->assertSee('<p class="rc_genre">'.$product->genre->name.'</p>')
                ->assertSee('<p class="rc_price">¥'.number_format($product->price).'(+tax)</p>')
                ->assertDontSee('<form action="/mypage/original_catalog/remove_process" class="remove_product_btn remove_product_from_catalog_btn" method="POST" name="remove_product_'.$product->id.'">')
                ->assertDontSee('<a href="javascript:remove_product_'.$product->id.'.submit()" onClick="return confirm(\'削除します。\nよろしいですか？\');">削除</a>');
        }
    }
}
