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

class EditProcessTest extends TestCase
{
    use DatabaseMigrations;
    //scenesテーブルのidに依存しているため、ここではDatabaseMigrationsを使用
    use WithFaker;

    public function testCanPost(){//データを変更できるか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $title = $this->faker->word();
        $scene_id = Scene::inRandomOrder()->first()->id;
        $date = $this->faker->dateTimeBetween('tomorrow', '+1years')->format('Y-m-d');

        $event = factory(Event::class)->create([
            'lover_id' => $lover->id,
            'title' => $title,
            'scene_id' => $scene_id,
            'date' => $date,
            'is_repeat' => true
        ]);

        $this->assertDatabaseHas('events',[
            'id' => $event->id,
            'lover_id' => $lover->id,
            'title' => $title,
            'scene_id' => $scene_id,
            'date' => $date,
            'is_repeat' => true,
        ]);

        $new_lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $new_title = $this->faker->word();
        $new_scene_id = Scene::inRandomOrder()->first()->id;
        $new_date = $this->faker->dateTimeBetween('tomorrow', '+1years')->format('Y-m-d');

        $response = $this->actingAs($user)
            ->post('/mypage/reminder/edit_process',[
                'event_id' => $event->id,
                'lover_id' => $new_lover->id,
                'title' => $new_title,
                'scene_id' => $new_scene_id,
                'date' => $new_date,
                'is_repeat' => false
            ]);

        $response->assertRedirect('/mypage/reminder/'.$event->id)
            ->assertSessionHas('suc_msg', '変更しました。')
            ->assertSessionHas('event_id', $event->id);

        $this->assertDatabaseMissing('events',[
            'id' => $event->id,
            'lover_id' => $lover->id,
            'title' => $title,
            'scene_id' => $scene_id,
            'date' => $date,
            'is_repeat' => true,
        ]);

        $this->assertDatabaseHas('events',[
            'id' => $event->id,
            'lover_id' => $new_lover->id,
            'title' => $new_title,
            'scene_id' => $new_scene_id,
            'date' => $new_date,
            'is_repeat' => false
        ]);
    }
}
