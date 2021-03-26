<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\TestUserCheck;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestUserCheckTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanReturnTrue()//テストユーザー以外を渡した時にエラーを返さないことを確認
    {
        $this->seed();

        $request = app()->make('request');
        $user = factory(User::class)->create([
            'email' => 'not_test'.$this->faker->safeEmail,
        ]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $request->merge(['user_id' => $user->id]);

        $middleware = new TestUserCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNull($response);
    }

    public function testCanReturnFalse()//テストユーザーを渡した時にエラーを返すことを確認
    {
        $this->seed();

        $request = app()->make('request');
        $user = factory(User::class)->create([
            'email' => 'test@example.com'
        ]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $request->merge(['user_id' => $user->id]);

        $middleware = new TestUserCheck();

        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $this->assertNotNull($response);
        $response->with('title','エラー')
            ->withSession('msg','テストアカウントは編集・削除できません。');
    }
}
