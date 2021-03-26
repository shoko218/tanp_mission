<?php

namespace Tests\Feature\Controller\MyPage\Lovers;

use App\Library\BaseClass;
use App\Model\Lover;
use App\Model\Order;
use App\Model\Order_log;
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
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/'.$lover->id);

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が見えているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);

        $orders = factory(Order::class,20)->create([
            'user_id' => $user->id,
            'lover_id' => $lover->id,
        ]);

        foreach ($orders as $order) {
            factory(Order_log::class,20)->create([
                'order_id' => $order->id,
            ]);
        }

        $reccomend_products=BaseClass::get_reccomends($lover->id);

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/'.$lover->id);

        $response->assertSee('<p class="lover_name">'.$lover->last_name.$lover->first_name.'さん</p>')
            ->assertSee('<button type="submit" form="register_event_form">イベント登録+</button>')
            ->assertSee('location.href=\'/mypage/lovers/'.$lover->id.'/gift_history\'">今まであげたもの</button>')
            ->assertSee('<a href="/mypage/lovers/'.$lover->id.'/edit">登録情報を確認・編集する</a>')
            ->assertSee('<a href="javascript:delete_form.submit()" onClick="return confirm(\'大切な人リストから削除します。\nよろしいですか？\');">大切な人リストから削除する</a>');

        if($reccomend_products !== null){
            foreach ($reccomend_products as $reccomend_product) {
                $response->assertSee('<p class="rc_title">'.$reccomend_product->name.'</p>')
                    ->assertSee('<p class="rc_genre">'.$reccomend_product->genre->name.'</p>')
                    ->assertSee('<p class="rc_price">¥'.number_format($reccomend_product->price).'(+tax)</p>');
            }
        }
    }
}
