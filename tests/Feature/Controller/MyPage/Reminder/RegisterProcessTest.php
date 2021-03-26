<?php

namespace Tests\Feature\Controller\MyPage\Reminder;

use App\Model\Event;
use App\Model\Lover;
use App\Model\Scene;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterProcessTest extends TestCase
{
    use DatabaseMigrations;
    //scenesテーブルのidに依存しているため、ここではDatabaseMigrationsを使用
    use WithFaker;

     public function testCanPost(){//登録できるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);

        $title = $this->faker->word();
        $scene_id = Scene::inRandomOrder()->first()->id;
        $date = $this->faker->dateTimeBetween('tomorrow', '+1years');

        $response = $this->actingAs($user)
            ->post('/mypage/reminder/register_process',[
                'lover_id' => $lover->id,
                'title' => $title,
                'scene_id' => $scene_id,
                'date' => $date->format('Y-m-d'),
                'is_repeat' => true
            ]);

        $response->assertRedirect('/mypage/reminder')
            ->assertSessionHas('suc_msg','登録しました。');

        $this->assertDatabaseHas('events',[
            'lover_id' => $lover->id,
            'title' => $title,
            'scene_id' => $scene_id,
            'date' => $date->format('Y-m-d'),
            'is_repeat' => true,
        ]);
     }
}
