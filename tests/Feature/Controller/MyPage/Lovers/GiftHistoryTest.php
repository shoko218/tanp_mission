<?php

namespace Tests\Feature\Controller\MyPage\Lovers;

use App\Model\Lover;
use App\Model\Order;
use App\Model\Order_log;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GiftHistoryTest extends TestCase
{    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $orders = factory(Order::class,20)->create([
            'user_id' => $user->id,
            'lover_id' => $lover->id
        ]);

        foreach ($orders as $order) {
            factory(Order_log::class)->create([
                'order_id' => $order->id
            ]);
        }

        $order_logs = Order_log::join('orders','orders.id',"order_id")
        ->select('order_logs.*')
        ->where('orders.lover_id','=',$lover->id)
        ->orderBy('id', 'desc')
        ->limit(12)
        ->get();

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/'.$lover->id.'/gift_history');

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が表示されているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $orders = factory(Order::class,20)->create([
            'user_id' => $user->id,
            'lover_id' => $lover->id
        ]);

        foreach ($orders as $order) {
            factory(Order_log::class)->create([
                'order_id' => $order->id
            ]);
        }

        $order_logs = Order_log::join('orders','orders.id',"order_id")
        ->select('order_logs.*')
        ->where('orders.lover_id','=',$lover->id)
        ->orderBy('id', 'desc')
        ->limit(12)
        ->get();

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/'.$lover->id.'/gift_history');

        foreach ($order_logs as $order_log) {
            $response->assertSee('<p class="od_title">'.$order_log->product->name.'</p>')
            ->assertSee('<p class="od_for">'.$order_log->order->forwarding_last_name.$order_log->order->forwarding_first_name.'さんへ</p>')
            ->assertSee('<p class="od_count">数量:'.$order_log->count.'</p>')
            ->assertSee('<p class="od_date">注文日:'.$order_log->created_at->format('Y年m月d日').'</p>');
        }
    }

    public function testCanShowNoHistory(){//履歴がない時にその旨を表示できているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/'.$lover->id.'/gift_history');
        $response->assertSee('<p class="nothing_msg">まだ商品はありません。</p>')
            ->assertSee('<button onclick="location.href=\'/search\'">商品を探しに行く</button>');
    }
}
