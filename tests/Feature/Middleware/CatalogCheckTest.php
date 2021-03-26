<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\CatalogCheck;
use App\Model\Catalog;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CatalogCheckTest extends TestCase
{
    use RefreshDatabase;

    public function testCanReturnTrue()//自分のカタログを選択した時にエラーを返さないことを確認
    {
        $this->seed();

        $request = app()->make('request');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create([
            'user_id' => $user->id,
        ]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $request->merge(['catalog_id' => $catalog->id]);


        $middleware = new CatalogCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNull($response);
    }

    public function testCanReturnFalse(){//自分のカタログ以外を選択した時にエラーを返すことを確認
        $this->seed();
        $request = app()->make('request');

        //他人のカタログを選択した場合
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create([
            'user_id' => $user->id,
        ]);

        $other_user =factory(User::class)->create();
        $other_catalog = factory(Catalog::class)->create([
            'user_id' => $other_user->id,
        ]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $request->merge(['catalog_id' => $other_catalog->id]);

        $middleware = new CatalogCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNotNull($response);
        $response->withSession('err_msg','エラーが発生しました。');

        //存在しないカタログidを選択した時
        $request->merge(['catalog_id' => -1]);

        $middleware = new CatalogCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNotNull($response);
        $response->withSession('err_msg','エラーが発生しました。');

        //カタログIDを渡していない場合
        $request->merge(['catalog_id' => null]);

        $middleware = new CatalogCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNotNull($response);
        $response->withSession('err_msg','エラーが発生しました。');
    }
}
