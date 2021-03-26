<?php

namespace Tests\Feature\Controller\MyPage\Lovers;

use App\Model\Lover;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProcessTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanPost(){//削除できるか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('lovers', [
            'id' => $lover->id,
        ]);

        $response = $this->actingAs($user)
            ->post('/mypage/lovers/delete_process', [
                'lover_id' => $lover->id,
                ]);

        $response->assertRedirect('/mypage/lovers/')
            ->assertSessionHas('suc_msg', '削除しました。');

        $this->assertDatabaseMissing('lovers', [
            'id' => $lover->id,
        ]);
    }
}
