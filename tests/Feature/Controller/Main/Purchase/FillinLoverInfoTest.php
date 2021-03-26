<?php

namespace Tests\Feature\Controller\Main\Purchase;

use App\Model\Lover;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FillinLoverInfoTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPost(){//要求通りの応答ができているか
        $this->seed('BaseSeeder');

        //値がある場合
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user)
            ->post('/purchase/fillin_lover_info',[
                'selected_lover_id' => $lover->id,
            ]);
        $response->assertRedirect('/purchase/fillin_info')
            ->assertSessionHas('selected_lover_id',$lover->id);

        //値がない(いいえが選択された)場合
        $response = $this->actingAs($user)
            ->post('/purchase/fillin_lover_info',[
                'selected_lover_id' => null,
            ]);
        $response->assertRedirect('/purchase/fillin_info')
            ->assertSessionMissing('selected_lover_id');
    }

    public function testCanRedirectIfLoverIsNotUsers(){//ユーザーが登録していない大切な人が選ばれた場合
        $this->seed('BaseSeeder');//戻す
        $lover = factory(Lover::class)->create();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->post('/purchase/fillin_lover_info',[
                'selected_lover_id' => $lover->id,
            ]);
        $response->assertRedirect('/purchase/fillin_info')
            ->assertSessionMissing('selected_lover_id')
            ->assertSessionHas('err_msg','エラーが発生しました。');
    }

    public function testCanRedirectIfLoverDoNotExists(){//存在していないidが選ばれた場合
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->post('/purchase/fillin_lover_info',[
                'selected_lover_id' => -1,
            ]);
        $response->assertRedirect('/purchase/fillin_info')
            ->assertSessionMissing('selected_lover_id')
            ->assertSessionHas('err_msg','エラーが発生しました。');
    }
}
