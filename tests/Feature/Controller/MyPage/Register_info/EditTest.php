<?php

namespace Tests\Feature\Controller\MyPage\Register_info;

use App\Http\Middleware\TestUserCheck;
use App\Model\Prefecture;
use App\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info/edit');

        $response->assertOk();
    }

    public function testCanUseForm()//フォームが成立しているか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info/edit');

        $response->assertSee('<input id="last_name" type="text" name="last_name"  value="'.$user->last_name.'"   placeholder="山田" required >')
            ->assertSee('<input id="first_name" type="text" name="first_name"  value="'.$user->first_name.'"   placeholder="太郎" required>')
            ->assertSee('<input id="last_name_furigana" type="text" name="last_name_furigana"  value="'.$user->last_name_furigana.'"   placeholder="ヤマダ" required >')
            ->assertSee('<input id="first_name_furigana" type="text" name="first_name_furigana"  value="'.$user->first_name_furigana.'"   placeholder="タロウ" required>')
            ->assertSee('<p class="go_other_page"><a href="edit_email">メールアドレスの変更はこちらから</a></p>')
            ->assertSee('<p class="go_other_page"><a href="edit_pass">パスワードの変更はこちらから</a></p>')
            ->assertSee('<input id="birthday" type="date" name="birthday"  value="'.$user->birthday->format('Y-m-d').'"  required  placeholder="1987-01-01">')
            ->assertSee('value="'.$user->gender.'" class="radiobtn"  checked="checked"')
            ->assertSee('<input id="postal_code" type="text" name="postal_code"  value="'.$user->postal_code.'"   placeholder="xxxxxxx">')
            ->assertSee('<textarea id="address" type="text" name="address" placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室" rows="2" >'.$user->address.'</textarea>')
            ->assertSee('<input id="telephone" type="text" name="telephone"  value="'.$user->telephone.'"  placeholder="xxxxxxxxxx" >')
            ->assertSee('<button type="submit">変更する</button>');

        $prefectures = Prefecture::get();
        foreach ($prefectures as $prefecture) {
            if($prefecture->id === $user->prefecture_id){
                $response->assertSee('<option value="'.$prefecture->id.'" selected >'.$prefecture->name.'</option>');
            }else{
                $response->assertSee('<option value="'.$prefecture->id.'">'.$prefecture->name.'</option>');
            }
        }
    }
}
