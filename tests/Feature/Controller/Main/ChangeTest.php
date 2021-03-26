<?php

namespace Tests\Feature\Controller\Main;

use App\Model\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangeTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGetResponse()
    {
        $this->seed('BaseSeeder');//戻す
        factory(Product::class,5)->create();
        $response = $this->get('/change');
        $response->assertJsonCount(2);
    }
}
