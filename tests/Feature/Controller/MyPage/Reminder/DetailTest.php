<?php

namespace Tests\Feature\Controller\MyPage\Reminder;

use App\Model\Event;
use App\Model\Lover;
use App\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DetailTest extends TestCase
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
            ->get('/mypage/reminder/'.$event->id);

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

        $to = new DateTime($event->date);
        $from = new DateTime();
        $from = date_create('today');
        $diff = $from->diff($to);

        $response = $this->actingAs($user)
            ->get('/mypage/reminder/'.$event->id);

        $response->assertSee('<h1 id="reminder_detail_explanation_title">'.$event->title.'まで<br><span>あと'.$diff->days.'日</span></h1>')
            ->assertSee('<p class="name"><i class="fas fa-user"></i>'.$event->lover->last_name.$event->lover->first_name.'さん</p>')
            ->assertSee('<button onclick="location.href=\'/make_result_url?target_scene_id='.$event->scene_id.'&amp;target_genre_id='.$event->genre_id.'&amp;target_relationship_id='.$event->lover->relationship_id.'&amp;target_gender='.$event->lover->gender.'&amp;target_generation_id='.(intval(floor((intval(date ( 'Ymd', time ()))-intval(str_replace('-', '', $event->lover->birthday)))/10000)/10)+1).'&amp;sort_by=0&amp;keyword=\'">プレゼントを探しに行く→</button>')
            ->assertSee('<a href="/mypage/reminder/'.$event->id.'/edit">このイベントを編集する</a>')
            ->assertSee('<a href="javascript:delete_form.submit()" onClick="return confirm(\'このイベントを削除します。\nよろしいですか？\');">このイベントを削除する</a>');
    }

    public function testCanCalcDiff(){//日付の差分を計算できているか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);

        $to = new DateTime();
        $to->modify('+100 days');

        $event = factory(Event::class)->create([
            'lover_id' => $lover->id,
            'date' => $to->format('Y-m-d'),
        ]);

        $from = new DateTime();
        $from = date_create('today');
        $diff = $from->diff($to);

        $response = $this->actingAs($user)
            ->get('/mypage/reminder/'.$event->id);

        $response->assertSee('<h1 id="reminder_detail_explanation_title">'.$event->title.'まで<br><span>あと100日</span></h1>');
    }
}
