<?php

namespace Tests\Feature\Controller\Main;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Model\Scene;
use App\Model\Relationship;
use App\Model\Genre;
use App\Model\Generation;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet()//アクセスできるか
    {
        $this->seed('BaseSeeder');//戻す
        $response = $this->get('/search');
        $response->assertOk();
    }

    public function testCanUseSearchForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');//戻す
        $response = $this->get('/search');
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

}
