<?php

namespace Tests\Feature\Controller\Main;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MakeResultUrlTest extends TestCase
{
    public function testCanMakeUrl()//期待通りにURLを作成できているか
    {
        //キーワード
        $response = $this->get('/make_result_url?keyword=test&target_scene_id=&target_genre_id=&target_relationship_id=&target_gender=&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?keyword=test');

        //シーン
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=&target_gender=&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&sort_by=0');

        //シーン、ジャンル
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=&target_gender=&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&sort_by=0');

        //シーン、ジャンル、関係性
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_relationship_id=1&sort_by=0');
        //シーン、ジャンル、関係性、性別
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=1&sort_by=0');
        //シーン、ジャンル、関係性、性別、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=0');
        //シーン、ジャンル、関係性、性別、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        //シーン、ジャンル、関係性、性別、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=1&sort_by=1');
        //シーン、ジャンル、関係性、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_generation_id=1&sort_by=0');
        //シーン、ジャンル、関係性、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_generation_id=1&sort_by=1');
        //シーン、ジャンル、関係性、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=1&target_gender=&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_relationship_id=1&sort_by=1');

        //シーン、ジャンル、性別
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=&target_gender=1&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_gender=1&sort_by=0');
        //シーン、ジャンル、性別、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=&target_gender=1&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_gender=1&target_generation_id=1&sort_by=0');
        //シーン、ジャンル、性別、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=&target_gender=1&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        //シーン、ジャンル、性別、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=&target_gender=1&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_gender=1&sort_by=1');

        //シーン、ジャンル、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=&target_gender=&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_generation_id=1&sort_by=0');
        //シーン、ジャンル、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=&target_gender=&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&target_generation_id=1&sort_by=1');

        //シーン、ジャンル、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=1&target_relationship_id=&target_gender=&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_genre_id=1&sort_by=1');

        //シーン、関係性
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=1&target_gender=&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_relationship_id=1&sort_by=0');

        //シーン、関係性、性別
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=1&target_gender=1&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_relationship_id=1&target_gender=1&sort_by=0');
        //シーン、関係性、性別、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=0');
        //シーン、関係性、性別、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        //シーン、関係性、性別、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=1&target_gender=1&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_relationship_id=1&target_gender=1&sort_by=1');

        //シーン、関係性、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=1&target_gender=&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_relationship_id=1&target_generation_id=1&sort_by=0');
        //シーン、関係性、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=1&target_gender=&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_relationship_id=1&target_generation_id=1&sort_by=1');

        //シーン、関係性、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=1&target_gender=&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_relationship_id=1&sort_by=1');

        //シーン、性別
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=&target_gender=1&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_gender=1&sort_by=0');
        //シーン、性別、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=&target_gender=1&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_gender=1&target_generation_id=1&sort_by=0');
        //シーン、性別、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=&target_gender=1&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        //シーン、性別、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=&target_gender=1&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_gender=1&sort_by=1');

        //シーン、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=&target_gender=&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_scene_id=1&target_generation_id=1&sort_by=0');
        //シーン、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=&target_gender=&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&target_generation_id=1&sort_by=1');

        //シーン、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=1&target_genre_id=&target_relationship_id=&target_gender=&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_scene_id=1&sort_by=1');

        //ジャンル
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=&target_gender=&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_genre_id=1&sort_by=0');

        //ジャンル、関係性
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=1&target_gender=&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_genre_id=1&target_relationship_id=1&sort_by=0');
        //ジャンル、関係性、性別
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_genre_id=1&target_relationship_id=1&target_gender=1&sort_by=0');
        //ジャンル、関係性、性別、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=0');
        //ジャンル、関係性、性別、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        //ジャンル、関係性、性別、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=1&target_gender=1&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_genre_id=1&target_relationship_id=1&target_gender=1&sort_by=1');
        //ジャンル、関係性、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=1&target_gender=&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_genre_id=1&target_relationship_id=1&target_generation_id=1&sort_by=0');
        //ジャンル、関係性、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=1&target_gender=&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_genre_id=1&target_relationship_id=1&target_generation_id=1&sort_by=1');
        //ジャンル、関係性、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=1&target_gender=&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_genre_id=1&target_relationship_id=1&sort_by=1');

        //ジャンル、性別
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=&target_gender=1&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_genre_id=1&target_gender=1&sort_by=0');
        //ジャンル、性別、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=&target_gender=1&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_genre_id=1&target_gender=1&target_generation_id=1&sort_by=0');
        //ジャンル、性別、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=&target_gender=1&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_genre_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        //ジャンル、性別、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=&target_gender=1&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_genre_id=1&target_gender=1&sort_by=1');

        //ジャンル、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=&target_gender=&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_genre_id=1&target_generation_id=1&sort_by=0');
        //ジャンル、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=&target_gender=&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_genre_id=1&target_generation_id=1&sort_by=1');

        //ジャンル、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=1&target_relationship_id=&target_gender=&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_genre_id=1&sort_by=1');

        //関係性
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=1&target_gender=&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_relationship_id=1&sort_by=0');

        //関係性、性別
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=1&target_gender=1&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_relationship_id=1&target_gender=1&sort_by=0');
        //関係性、性別、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=0');
        //関係性、性別、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_relationship_id=1&target_gender=1&target_generation_id=1&sort_by=1');
        //関係性、性別、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=1&target_gender=1&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_relationship_id=1&target_gender=1&sort_by=1');

        //関係性、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=1&target_gender=&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_relationship_id=1&target_generation_id=1&sort_by=0');
        //関係性、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=1&target_gender=&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_relationship_id=1&target_generation_id=1&sort_by=1');

        //関係性、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=1&target_gender=&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_relationship_id=1&sort_by=1');

        //性別
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=&target_gender=1&target_generation_id=&sort_by=');
        $response->assertRedirect('/result?target_gender=1&sort_by=0');
        //性別、世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=&target_gender=1&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_gender=1&target_generation_id=1&sort_by=0');
        //性別、世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=&target_gender=1&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_gender=1&target_generation_id=1&sort_by=1');
        //性別、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=&target_gender=1&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?target_gender=1&sort_by=1');

        //世代
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=&target_gender=&target_generation_id=1&sort_by=');
        $response->assertRedirect('/result?target_generation_id=1&sort_by=0');
        //世代、ソート
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=&target_gender=&target_generation_id=1&sort_by=1');
        $response->assertRedirect('/result?target_generation_id=1&sort_by=1');

        //ソートのみ
        $response = $this->get('/make_result_url?keyword=&target_scene_id=&target_genre_id=&target_relationship_id=&target_gender=&target_generation_id=&sort_by=1');
        $response->assertRedirect('/result?sort_by=1');

        //指定なし
        $response = $this->get('/make_result_url');
        $response->assertRedirect('/result?sort_by=0');
    }
}
