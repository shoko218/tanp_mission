<?php

namespace Tests\Feature\Controller\MyPage\Lovers;

use App\Model\Lover;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;


    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        factory(Lover::class,20)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/');

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が表示されているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        factory(Lover::class,20)->create([
            'user_id' => $user->id,
        ]);

        $lovers = Lover::where('user_id',$user->id)->get();

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/');

        $response->assertSee('<button onclick="location.href=\'/mypage/lovers/register\'">新しい大切な人を登録→</button>');

        foreach ($lovers as $lover) {
            $response->assertSee('<p class="lv_name">'.$lover->last_name.$lover->first_name.' さん</p>')
            ->assertSee('<p class="lv_relationship"><i class="fas fa-people-arrows"></i>'.$lover->relationship->name.'</p>');
        }
    }

    public function testCanShowNoEvent(){//大切な人が登録されていない時にその旨を表示し、登録画面への誘導ボタンを表示できているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/');

        $response->assertSee('<h2>まだ大切な人は登録されていません。</h2>')
            ->assertSee('<button onclick="location.href=\'/mypage/lovers/register\'">新しい大切な人を登録→</button>');
    }
}
