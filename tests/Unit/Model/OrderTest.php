<?php

namespace Tests\Unit\Model;

use App\Model\Order;
use App\Model\Order_log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        $eloquent = app(Order::class);
        $this->assertEmpty($eloquent->get());
        factory(Order::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testOrderHasManyOrder_logs()
    {
        $count = 10;
        $this->seed('BaseSeeder');
        $order = factory(Order::class)->create();
        factory(Order_log::class,$count)->create([
            'order_id' => $order->id,
        ]);
        $this->assertEquals($count,count($order->refresh()->order_logs));
    }

}
