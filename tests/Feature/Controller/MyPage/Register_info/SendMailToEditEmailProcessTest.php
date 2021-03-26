<?php

namespace Tests\Feature\Controller\MyPage\Register_info;

use App\Http\Middleware\TestUserCheck;
use App\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendMailToEditEmailProcessTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanPost(){//DBに情報を登録し、メールを送信できるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $new_email = $this->faker->safeEmail;

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->post('/mypage/register_info/send_mail_to_edit_email_process',[
                'email' => $new_email,
            ]);

        $response->assertRedirect('/msg')
            ->assertSessionHas('title', '送信完了')
            ->assertSessionHas('msg', '確認メールを送信しました。');

        $this->assertDatabaseHas('email_resets',[
            'user_id' => $user->id,
            'new_email' => $new_email
        ]);
    }
}
