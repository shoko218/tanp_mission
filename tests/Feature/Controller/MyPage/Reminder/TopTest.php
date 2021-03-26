<?php

namespace Tests\Feature\Controller\MyPage\Reminder;

use App\Model\Event;
use App\Model\Lover;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TopTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lovers = factory(Lover::class,20)->create([
            'user_id' => $user->id,
        ]);
        foreach ($lovers as $lover) {
            factory(Event::class)->create([
                'lover_id' => $lover->id,
            ]);
        }

        $events=Event::join('lovers', 'lover_id', '=', 'lovers.id')
        ->where('lovers.user_id',$user->id)
        ->select(DB::raw('events.*'))
        ->orderby('date','asc')
        ->limit(12)
        ->get();

        $response = $this->actingAs($user)
            ->get('/mypage/reminder/');

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が表示されているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $lovers = factory(Lover::class,20)->create([
            'user_id' => $user->id,
        ]);
        foreach ($lovers as $lover) {
            factory(Event::class)->create([
                'lover_id' => $lover->id,
            ]);
        }

        $events=Event::join('lovers', 'lover_id', '=', 'lovers.id')
        ->where('lovers.user_id',$user->id)
        ->select(DB::raw('events.*'))
        ->orderby('date','asc')
        ->limit(12)
        ->get();

        $response = $this->actingAs($user)
            ->get('/mypage/reminder/');

        $response->assertSee('<button onclick="location.href=\'/mypage/reminder/register\'">新しいイベントを登録→</button>');

        foreach ($events as $event) {
            $response->assertSee('<p class="an_date">'.$event->date.'</p>')
            ->assertSee('<p class="an_event">'.$event->title.'</p>')
            ->assertSee('<p class="an_person"><i class="fas fa-user"></i>'.$event->lover->last_name.$event->lover->first_name.' さん</p>');
        }
    }

    public function testCanShowNoEvent(){//イベントがない時にその旨を表示し、登録画面への誘導ボタンを表示できているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/reminder/');

        $response->assertSee('<h2>まだイベントはありません。</h2>')
            ->assertSee('<button onclick="location.href=\'/mypage/reminder/register\'">新しいイベントを登録→</button>');
    }
}
