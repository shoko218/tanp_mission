<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\ProductCheck;
use App\Model\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCheckTest extends TestCase
{
    use RefreshDatabase;

    public function testCanReturnTrue()//存在する商品を選択した時にエラーを返さないことを確認
    {
        $this->seed();

        $request = app()->make('request');
        $product = factory(Product::class)->create();

        $request->merge(['product_id' => $product->id]);


        $middleware = new ProductCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNull($response);
    }

    public function testCanReturnFalse(){//存在する商品以外を選択した時にエラーを返すことを確認
        $this->seed();
        $request = app()->make('request');

        //存在しない商品IDを選択した場合
        $request->merge(['product_id' => -1]);

        $middleware = new ProductCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNotNull($response);
        $response->withSession('err_msg', 'エラーが発生しました。');

        //商品IDを渡していない場合
        $request->merge(['product_id' => null]);

        $middleware = new ProductCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNotNull($response);
        $response->withSession('err_msg', 'エラーが発生しました。');
    }
}
