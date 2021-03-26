<?php

namespace Tests\Feature\Controller\MyPage\Reminder;

use App\Model\Event;
use App\Model\Lover;
use App\Model\Scene;
use App\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $event = factory(Event::class)->create([
            'lover_id' => $lover->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/reminder/'.$event->id.'/edit');

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が表示されているか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $event = factory(Event::class)->create([
            'lover_id' => $lover->id,
        ]);

        $today = new DateTime();
        $today = date_create('today');

        $response = $this->actingAs($user)
            ->get('/mypage/reminder/'.$event->id.'/edit');

        $response->assertOk()
            ->assertSee('<option value="'.$event->lover->id.'"  selected >'.$event->lover->last_name.$event->lover->first_name.'</option>')
            ->assertSee('<option value="'.$event->scene->id.'"  selected >'.$event->scene->name.'</option>')
            ->assertSee('<input type="date" name="date"  value="'.$event->date.'"  min="'.$today->format('Y-m-d').'" required  placeholder="1987-01-01">')
            ->assertSee('<label class="radio"><input type="radio" name="is_repeat" value="'.(int)$event->is_repeat.'" class="radiobtn"  checked="checked" >')
            ->assertSee('<input type="hidden" name="event_id" value="'.$event->id.'">');
    }

    public function testCanUseSearchForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lovers = factory(Lover::class,10)->create([
            'user_id' => $user->id,
        ]);
        $event = factory(Event::class)->create([
            'lover_id' => $lovers[0]->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/reminder/'.$event->id.'/edit');

        foreach ($lovers as $lover) {
            $response->assertSee($lover->last_name.$lover->first_name.'</option>');
        }

        $scenes = Scene::get();
        foreach ($scenes as $scene) {
            $response->assertSee($scene->name.'</option>');
        }
    }
}
