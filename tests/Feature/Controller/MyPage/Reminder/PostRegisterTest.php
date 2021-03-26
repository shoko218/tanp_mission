<?php

namespace Tests\Feature\Controller\MyPage\Reminder;

use App\Model\Lover;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testCanRedirect(){//リダイレクトできるか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->post('/mypage/reminder/register',[
                'lover_id' => $lover->id,
            ]);

        $response->assertRedirect('/mypage/reminder/register')
            ->assertSessionHas('selected_lover_id',$lover->id);
    }
}
