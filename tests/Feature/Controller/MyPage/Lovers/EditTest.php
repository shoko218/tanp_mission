<?php

namespace Tests\Feature\Controller\MyPage\Lovers;

use App\Model\Lover;
use App\Model\Prefecture;
use App\Model\Relationship;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet()
    {//アクセスできるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/'.$lover->id.'edit');

        $response->assertOk();
    }

    public function testCanUseForm()
    {//フォームが成立しているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/lovers/'.$lover->id.'/edit');

        $response->assertSee('action="/mypage/lovers/edit_process"')
            ->assertSee('<input id="last_name" type="text" name="last_name"  value="'.$lover->last_name.'"  placeholder="山田"  required >')
            ->assertSee('<input id="first_name" type="text" name="first_name"  value="'.$lover->first_name.'"  placeholder="太郎"  required>')
            ->assertSee('<input id="last_name_furigana" type="text" name="last_name_furigana"  value="'.$lover->last_name_furigana.'"  placeholder="ヤマダ"  required >')
            ->assertSee('<input id="first_name_furigana" type="text" name="first_name_furigana"  value="'.$lover->first_name_furigana.'"  placeholder="タロウ"  required>')
            ->assertSee('<input id="birthday" type="date" name="birthday"  value="'.$lover->birthday.'"   required placeholder="1987-01-01">')
            ->assertSee('<label class="radio"><input type="radio" name="gender" value="'.$lover->gender.'" class="radiobtn"  checked="checked"')
            ->assertSee('<input id="postal_code" type="text" name="postal_code"  value="'.$lover->postal_code.'"  placeholder="xxxxxxx" >')
            ->assertSee('<input id="address" type="text" name="address"  value="'.$lover->address.'"  placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室" >')
            ->assertSee('<input id="telephone" type="text" name="telephone"  value="'.$lover->telephone.'"  placeholder="xxxxxxxxxx" >')
            ->assertSee('<lover-img-component :err-msgs=\'[]\'  ></lover-img-component>')
            ->assertSee('<button type="submit">変更する</button>');

        $prefectures = Prefecture::get();
        foreach ($prefectures as $prefecture) {
            $response->assertSee($prefecture->name.'</option>');
        }

        $relationships = Relationship::get();
        foreach ($relationships as $relationship) {
            $response->assertSee($relationship->name.'</option>');
        }
    }
}
