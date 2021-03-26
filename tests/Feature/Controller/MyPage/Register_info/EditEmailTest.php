<?php

namespace Tests\Feature\Controller\MyPage\Register_info;

use App\Http\Middleware\TestUserCheck;
use App\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditEmailTest extends TestCase
{
    use RefreshDatabase;
    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info/edit_email');

        $response->assertOk();
    }

    public function testCanUseForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info/edit_email');

        $response->assertSee('action="send_mail_to_edit_email_process"')
            ->assertSee('<input id="email" type="email" name="email" value="" placeholder="example@mail.com" required autocomplete="email" >')
            ->assertSee('<button type="submit">送信</button>');
    }
}
