<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/');

        $response->assertOk();
    }

    public function testCanShowContents(){//内容が表示されているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/');

        $response->assertSee('<h1>オリジナルカタログ</h1>')
            ->assertSee('<button onclick="location.href=\'/mypage/original_catalog/register\'">新しくカタログを作る</button>')
            ->assertSee('<h2>今までに作ったオリジナルカタログ</h2>');
    }
}
