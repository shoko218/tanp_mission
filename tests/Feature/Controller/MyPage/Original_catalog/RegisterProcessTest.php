<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterProcessTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanPost()//データを登録できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $infos =[
            'name' => $this->faker->firstName,
            'email' => $this->faker->safeEmail,
            'img_num' => 1,
        ];

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/register_process',$infos);

        $response->assertRedirect('/mypage/original_catalog')
                ->assertSessionHas('suc_msg','カタログを作成しました。');

        $this->assertDatabaseHas('catalogs',$infos);
    }
}
