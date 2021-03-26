<?php

namespace Tests\Feature\Controller\Main;

use App\Model\Generation;
use App\Model\Genre;
use App\Model\Product;
use App\Model\Relationship;
use App\Model\Scene;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;

class ResultTest extends TestCase
{
    use DatabaseMigrations;
    //検索条件がidに依存しているため、ここではDatabaseMigrationsを使用

    public function testCanGet()//アクセスできるか
    {
        $response = $this->get('/result?target_scene_id=2&sort_by=0');
        $response->assertOk();
    }

    public function testCanRedirect(){//リダイレクトができているか
        $response = $this->get('/result');
        $response->assertRedirect('/search');
    }

    public function testCanUseSearchForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');//戻す
        $response = $this->get('/result?target_scene_id=2&sort_by=0');
        $response->assertSee('action="/make_result_url"')
            ->assertSee('id="search_bar"')
            ->assertSee('id="change_btn"')
            ->assertSee('class="search_btn"');

        $scenes = Scene::get();
        foreach ($scenes as $scene) {
            $response->assertSee($scene->name);
        }

        $relationships = Relationship::get();
        foreach ($relationships as $relationship) {
            $response->assertSee($relationship->name);
        }

        $genres = Genre::get();
        foreach ($genres as $genre) {
            $response->assertSee($genre->name);
        }

        $generations = Generation::get();
        foreach ($generations as $generation) {
            $response->assertSee($generation->name);
        }
    }

    public function testCanSeeTrueResult(){
        $this->seed('BaseSeeder');//戻す

        //選択検索
        $response = $this->get('/result?target_scene_id=1&target_genre_id=1&target_relationship_id=2&target_gender=1&target_generation_id=3&sort_by=1');
        $results = DB::select('select `products`.*, `counts`.`count` as `count` from `products` left join (select `product_id`, sum(count) as count from `order_logs` inner join `orders` on `order_id` = `orders`.`id` group by `product_id`) as `counts` on `products`.`id` = `counts`.`product_id` inner join (select `product_id`, count(*) as scene_count_raw from `order_logs` inner join `orders` on `order_id` = `orders`.`id` where `orders`.`scene_id` = 1 group by `product_id`) as `scene_counts` on `products`.`id` = `scene_counts`.`product_id` inner join (select `product_id`, count(*) as relationship_count_raw from `order_logs` inner join `orders` on `order_id` = `orders`.`id` where `orders`.`relationship_id` = 2 group by `product_id`) as `relationship_counts` on `products`.`id` = `relationship_counts`.`product_id` inner join (select `product_id`, count(*) as gender_count_raw from `order_logs` inner join `orders` on `order_id` = `orders`.`id` where `orders`.`gender` = 1 group by `product_id`) as `gender_counts` on `products`.`id` = `gender_counts`.`product_id` inner join (select `product_id`, count(*) as generation_count_raw from `order_logs` inner join `orders` on `order_id` = `orders`.`id` where `orders`.`generation_id` = 3 group by `product_id`) as `generation_counts` on `products`.`id` = `generation_counts`.`product_id` where `products`.`genre_id` = 1 order by `count` desc limit 12');
        foreach ($results as $result) {
            $response->assertSee('<p class="rc_title">'.$result->name.'</p>');
        }

        //キーワード検索
        $product = factory(Product::class)->create();
        $response = $this->get('/result?keyword='.$product->name);
        $result = DB::select('select * from `products` left join (select `product_id`, sum(count) as count from `order_logs` inner join `orders` on `order_id` = `orders`.`id` group by `product_id`) as `counts` on `products`.`id` = `counts`.`product_id` where (`name` like "'.$product->name.'" or `name` like "'.mb_convert_kana($product->name, "c").'" or `name` like "'.mb_convert_kana($product->name, "c").'" or `name` like "'.strtolower($product->name).'" or `name` like "'.strtoupper($product->name).'") limit 12');
        $response->assertSee('<p class="rc_title">'.$product->name.'</p>');
    }
}
