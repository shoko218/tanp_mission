<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\EventCheck;
use App\Model\Event;
use App\Model\Lover;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventCheckTest extends TestCase
{
    use RefreshDatabase;

    public function testCanReturnTrue()//自分のイベントを選択した時にエラーを返さないことを確認
    {
        $this->seed();

        $request = app()->make('request');
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $event = factory(Event::class)->create([
            'lover_id' => $lover->id,
        ]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $request->merge(['event_id' => $event->id]);


        $middleware = new EventCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNull($response);
    }

    public function testCanReturnFalse(){//自分のイベント以外を選択した時にエラーを返すことを確認
        $this->seed();
        $request = app()->make('request');

        //他人のイベントを選択した場合
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $event = factory(Event::class)->create([
            'lover_id' => $lover->id,
        ]);

        $other_user =factory(User::class)->create();
        $other_lover = factory(Lover::class)->create([
            'user_id' => $other_user->id,
        ]);
        $other_event = factory(Event::class)->create([
            'lover_id' => $other_lover->id,
        ]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $request->merge(['event_id' => $other_event->id]);

        $middleware = new EventCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNotNull($response);
        $response->withSession('err_msg','エラーが発生しました。');

        //存在しないイベントidを選択した時
        $request->merge(['event_id' => -1]);

        $middleware = new EventCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNotNull($response);
        $response->withSession('err_msg','エラーが発生しました。');

        //イベントIDを渡していない場合
        $request->merge(['event_id' => null]);

        $middleware = new EventCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNotNull($response);
        $response->withSession('err_msg','エラーが発生しました。');
    }
}
