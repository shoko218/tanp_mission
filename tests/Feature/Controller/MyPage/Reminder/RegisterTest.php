<?php

namespace Tests\Feature\Controller\MyPage\Reminder;

use App\Model\Event;
use App\Model\Lover;
use App\Model\Scene;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lovers = factory(Lover::class,10)->create([
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user)
            ->get('/mypage/reminder/register');
        $response->assertOk();
    }

    public function testCanUseForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lovers = factory(Lover::class,10)->create([
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user)
            ->get('/mypage/reminder/register');

        $response->assertSee('action="/mypage/reminder/register_process"')
            ->assertSee('<select id="lover_id" name="lover_id" required>')
            ->assertSee('<input id="title" name="title" value="" required >')
            ->assertSee('<select id="scene_id" name="scene_id" required >')
            ->assertSee('<input type="date" name="date" value="" min="'.date('Y-m-d').'" required  placeholder="1987-01-01">')
            ->assertSee('<label class="radio"><input type="radio" name="is_repeat" value="1" class="radiobtn"  required>はい</label>')
            ->assertSee('<label class="radio"><input type="radio" name="is_repeat" value="0" class="radiobtn" >いいえ</label>')
            ->assertSee('<button>登録</button>');

        foreach ($lovers as $lover) {
            $response->assertSee('<option value="'.$lover->id.'"  >'.$lover->last_name.$lover->first_name.'</option>');
        }

        $scenes = Scene::get();
        foreach ($scenes as $scene) {
            $response->assertSee('<option value="'.$scene->id.'" >'.$scene->name.'</option>');
        }
    }
}
