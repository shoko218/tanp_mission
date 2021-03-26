<?php

namespace Tests\Feature\Controller\MyPage\Register_info;

use App\Http\Middleware\TestUserCheck;
use App\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditPassProcessTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanPost(){//登録できるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $infos =[
            'current_password' => 'password',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword'
        ];

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->post('/mypage/register_info/edit_pass_process',$infos);

        $response->assertRedirect('/mypage/register_info')
            ->assertSessionHas('suc_msg','パスワードを変更しました。');
    }

    public function testCanReturnError(){//エラーを返せるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $infos =[
            'current_password' => 'wrongpassword',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword'
        ];

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->post('/mypage/register_info/edit_pass_process',$infos);

        $response->assertRedirect('/mypage/register_info/edit_pass_process')
            ->assertSessionHas('err_msg', '現在のパスワードが間違っています。');
    }
}
