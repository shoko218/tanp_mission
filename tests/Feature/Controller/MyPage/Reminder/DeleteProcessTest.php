<?php

namespace Tests\Feature\Controller\MyPage\Reminder;

use App\Model\Event;
use App\Model\Lover;
use App\Model\Scene;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProcessTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

     public function testCanPost(){//削除できるか
         $this->seed('BaseSeeder');
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

         $this->assertDatabaseHas('events', [
            'lover_id' => $lover->id,
            'title' => $title,
            'scene_id' => $scene_id,
            'date' => $date,
            'is_repeat' => true,
        ]);

        $response = $this->actingAs($user)
        ->post('/mypage/reminder/delete_process', [
            'event_id' => $event->id,
        ]);

        $response->assertRedirect('mypage/reminder')
            ->assertSessionHas('suc_msg','削除しました。');

        $this->assertDatabaseMissing('events',[
            'id' => $event->id,
            'lover_id' => $lover->id,
            'title' => $title,
            'scene_id' => $scene_id,
            'date' => $date,
            'is_repeat' => true,
        ]);
    }
}
