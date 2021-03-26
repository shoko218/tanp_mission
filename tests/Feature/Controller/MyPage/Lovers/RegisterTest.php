<?php

namespace Tests\Feature\Controller\MyPage\Lovers;

use App\Model\Prefecture;
use App\Model\Relationship;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/mypage/lovers/register');

        $response->assertOk();
    }

    public function testCanUseForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/mypage/lovers/register');

        $response->assertSee('action="/mypage/lovers/register_process"')
            ->assertSee('<input id="last_name" type="text" name="last_name" value="" placeholder="山田"  required >')
            ->assertSee('<input id="first_name" type="text" name="first_name" value="" placeholder="太郎"  required>')
            ->assertSee('<input id="last_name_furigana" type="text" name="last_name_furigana" value="" placeholder="ヤマダ"  required >')
            ->assertSee('<input id="first_name_furigana" type="text" name="first_name_furigana" value="" placeholder="タロウ"  required>')
            ->assertSee('<input id="birthday" type="date" name="birthday" value=""  required placeholder="1987-01-01">')
            ->assertSee('<label class="radio"><input type="radio" name="gender" value="0" class="radiobtn" >男性</label>')
            ->assertSee('<input id="postal_code" type="text" name="postal_code" value="" placeholder="xxxxxxx"  >')
            ->assertSee('<input id="address" type="text" name="address" value="" placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室" >')
            ->assertSee('<input id="telephone" type="text" name="telephone" value="" placeholder="xxxxxxxxxx" >')
            ->assertSee('<lover-img-component :err-msgs=\'[]\'></lover-img-component>')
            ->assertSee('<button>登録</button>');

        $prefectures = Prefecture::get();
        foreach ($prefectures as $prefecture) {
            $response->assertSee('<option value="'.$prefecture->id.'">'.$prefecture->name.'</option>');
        }

        $relationships = Relationship::get();
        foreach ($relationships as $relationship) {
            $response->assertSee('<option value="'.$relationship->id.'">'.$relationship->name.'</option>');
        }
    }
}
