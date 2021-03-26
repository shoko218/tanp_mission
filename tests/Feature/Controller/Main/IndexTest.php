<?php

namespace Tests\Feature\Controller\Main;

use App\Model\Generation;
use App\Model\Genre;
use App\Model\Order;
use App\Model\Order_log;
use App\Model\Product;
use App\Model\Relationship;
use App\Model\Scene;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\User;

class IndexTestController extends TestCase
{
    use DatabaseMigrations;
    //scenesテーブルのidに依存しているため、ここではDatabaseMigrationsを使用

    public function testCanGet()//アクセスできるか
    {
        $this->seed('BaseSeeder');//戻す
        $response = $this->get('/');
        $response->assertOk();
    }

    public function testCanSeeContents(){ //コンテンツが見えているか
        $this->seed('BaseSeeder');//戻す
        $response = $this->get('/');
        $response->assertSeeText('プレゼントを探す')
            ->assertSeeText('20代の方に人気のプレゼントランキング')
            ->assertSeeText('グルメプレゼントランキング');
    }

    public function testCanSeeRanking(){//ランキングが正しく表示されているか
        $this->seed();//戻す
        $response = $this->get('/');

        //年代ランキング
        $generation_results = DB::select('select products.* ,(`generation_count_raw`) as relevance_count from `products` left join (select `product_id`, sum(count) as count from `order_logs` inner join `orders` on `order_id` = `orders`.`id` group by `product_id`) as `counts` on `products`.`id` = `counts`.`product_id` inner join (select `product_id`, count(*) as generation_count_raw from `order_logs` inner join `orders` on `order_id` = `orders`.`id` where `orders`.`generation_id` = 3 group by `product_id`) as `generation_counts` on `products`.`id` = `generation_counts`.`product_id` order by `relevance_count` desc limit 3');
        foreach($generation_results as $generation_result){
            $response->assertSee('<p class="rc_title">'.$generation_result->name.'</p>');
        }

        //ジャンルランキング
        $genre_results = DB::select('select `products`.*, `counts`.`count` as `count` from `products` left join (select `product_id`, sum(count) as count from `order_logs` inner join `orders` on `order_id` = `orders`.`id` group by `product_id`) as `counts` on `products`.`id` = `counts`.`product_id` where `products`.`genre_id` = 1 order by `count` desc limit 3');
        foreach($genre_results as $genre_result){
            $response->assertSee('<p class="rc_title">'.$genre_result->name.'</p>');
        }
    }

    public function testCanDistinctionAuth(){//ログインの見分けがついているか
        $this->seed('BaseSeeder');//戻す
        $response = $this->get('/');
        $response->assertSee('href="/login"')
            ->assertDontSee('href="/mypage/reminder"');//ログイン前

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/');
        $response->assertDontSee('href="/login"')
            ->assertSee('href="/mypage/reminder"');//ログイン後
    }

    public function testCanUseSearchForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');//戻す
        $response = $this->get('/');
        $response->assertSee('action="/make_result_url" ')
            ->assertSee('id="search_bar"')
            ->assertSee('id="change_btn"')
            ->assertSee('class="search_btn"');

        $scenes = Scene::get();
        foreach ($scenes as $scene) {
            $response->assertSee('<option value='.$scene->id.' >'.$scene->name.'</option>');
        }

        $relationships = Relationship::get();
        foreach ($relationships as $relationship) {
            $response->assertSee('<option value='.$relationship->id.' >'.$relationship->name.'</option>');
        }

        $genres = Genre::get();
        foreach ($genres as $genre) {
            $response->assertSee('<option value='.$genre->id.' >'.$genre->name.'</option>');
        }

        $generations = Generation::get();
        foreach ($generations as $generation) {
            $response->assertSee('<option value='.$generation->id.' >'.$generation->name.'</option>');
        }
    }
}
