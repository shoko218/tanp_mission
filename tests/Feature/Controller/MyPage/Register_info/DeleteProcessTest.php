<?php

namespace Tests\Feature\Controller\MyPage\Register_info;

use App\Http\Middleware\TestUserCheck;
use App\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPost()//削除処理ができるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $user_id = $user->id;

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
        ->actingAs($user)
        ->post('/mypage/register_info/delete');

        $response->assertRedirect('/msg')
            ->assertSessionHas('title','退会処理完了')
            ->assertSessionHas('msg','退会処理が完了しました。');

        $this->assertDatabaseMissing('users',[
            'id' => $user_id,
        ]);
    }
}
