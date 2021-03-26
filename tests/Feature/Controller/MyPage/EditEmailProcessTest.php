<?php

namespace Tests\Feature\Controller\MyPage;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Str;
use App\Model\EmailReset;
use DateTime;

class EditEmailProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testCanChangeEmail()//メールアドレスを変更できるか
    {
        $this->seed('BaseSeeder');
        $token = hash_hmac(
            'sha256',
            Str::random(40) . 'test@example.com',
            config('app.key')
        );

        $user = factory(User::class)->create();
        $old_email = $user->email;
        $param = [];
        $param['user_id'] = $user->id;
        $param['new_email'] = 'test@example.com';
        $param['token'] = $token;
        $email_reset = EmailReset::create($param);

        $response = $this->get('/edit_email_process/'.$token);
        $response->assertRedirect('/msg')
            ->assertSessionHas('title', 'メールアドレス更新完了')
            ->assertSessionHas('msg', 'メールアドレスを更新しました！');

        $this->assertDatabaseMissing('users', [//データベース確認
            'email' => $old_email,
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function testCanShowError(){//エラー(トークンに合うデータなし、期限切れ)を検知し、表示できるか
        $this->seed('BaseSeeder');
                $token = hash_hmac(
            'sha256',
            Str::random(40) . 'test@example.com',
            config('app.key')
        );

        $user = factory(User::class)->create();
        $old_email = $user->email;
        $param = [];
        $param['user_id'] = $user->id;
        $param['new_email'] = 'test@example.com';
        $param['token'] = $token;
        $email_reset = EmailReset::create($param);

        $response = $this->get('/edit_email_process/hogehash');//トークンに合うデータなし
        $response->assertRedirect('/msg')
            ->assertSessionHas('title', 'メールアドレス更新失敗')
            ->assertSessionHas('msg', 'メールアドレスの更新に失敗しました。');

        $this->assertDatabaseHas('users', [//データベース確認
            'email' => $old_email,
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);

        $true_time = new DateTime($email_reset->created_at);
        $wrong_time = $true_time->modify('-1 hours');
        $email_reset->created_at = $wrong_time->format('Y-m-d H:i:s');
        $email_reset->save();

        $response = $this->get('/edit_email_process/'.$token);//期限切れ
        $response->assertRedirect('/msg')
            ->assertSessionHas('title', 'メールアドレス更新失敗')
            ->assertSessionHas('msg', 'メールアドレスの更新に失敗しました。');

        $this->assertDatabaseHas('users', [//データベースのメアドが変更されていないことを確認
            'email' => $old_email,
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);


    }
}
