<?php

namespace Tests\Unit\Model;

use App\Model\Order;
use App\Model\Order_log;
use Tests\TestCase;
use App\Model\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderLogTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeable()
    {
        $this->seed('BaseSeeder');
        $eloquent = app(Order_log::class);
        $this->assertEmpty($eloquent->get());
        factory(Order_log::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testOrderLogBelongsToProduct()
    {
        $this->seed('BaseSeeder');
        $product = factory(Product::class)->create();
        $order_log = factory(Order_log::class)->create([
            'product_id' => $product->id,
        ]);
        $this->assertNotEmpty($order_log->product);
    }

    public function testOrderLogBelongsToOrder()
    {
        $this->seed('BaseSeeder');
        $order = factory(Order::class)->create();
        $order_log = factory(Order_log::class)->create([
            'order_id' => $order->id,
        ]);
        $this->assertNotEmpty($order_log->order);
    }
}
