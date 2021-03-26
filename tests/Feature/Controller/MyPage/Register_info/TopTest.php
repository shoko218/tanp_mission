<?php

namespace Tests\Feature\Controller\MyPage\Register_info;

use App\Http\Middleware\TestUserCheck;
use App\Model\Prefecture;
use App\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info');

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が表示されているか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info');

        $response->assertSee('<td>'.$user->last_name.'</td>')
            ->assertSee('<td>'.$user->first_name.'</td>')
            ->assertSee('<td>'.$user->last_name_furigana.'</td>')
            ->assertSee('<td>'.$user->first_name_furigana.'</td>')
            ->assertSee('<td>'.$user->email.'</td>')
            ->assertSee('<td>'.$user->birthday->format('Y/m/d').'</td>')
            ->assertSee('<td>'.$user->postal_code.' </td>')
            ->assertSee('<td> '.$user->prefecture->name.' </td>')
            ->assertSee('<td>'.$user->address.' </td>')
            ->assertSee('<td>'.$user->telephone.' </td>')
            ->assertSee('<h2 class="submit_a"><a href="/mypage/register_info/edit">登録情報を編集する</a></h2>')
            ->assertSee('action="/mypage/register_info/delete"')
            ->assertSee('<h2 class="submit_a"><a href="javascript:delete_form.submit()" onClick="return confirm(\'退会すると登録している情報は削除され、二度と復元できなくなってしまいます。\n本当によろしいですか？\');">Pleasedを退会する</a></h2>');

        switch ($user->gender) {
            case 0:
                $response->assertSee('<td> 男性 </td>');
                break;
            case 1:
                $response->assertSee('<td> 女性 </td>');
                break;
            case 2:
                $response->assertSee('<td> その他 </td>');
                break;
        }

        //未設定を表示できるか
        $user->postal_code = null;
        $user->save();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info');

        $response->assertSee('<td> 未設定 </td>');

        $user->postal_code = $this->faker->postcode;
        $user->prefecture_id = null;
        $user->save();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info');

        $response->assertSee('<td> 未設定 </td>');

        $user->prefecture_id = Prefecture::inRandomOrder()->first()->id;
        $user->address = null;
        $user->save();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info');

        $response->assertSee('<td> 未設定 </td>');

        $user->address = $this->faker->streetAddress;
        $user->telephone = null;
        $user->save();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info');

        $response->assertSee('<td> 未設定 </td>');
    }
}
