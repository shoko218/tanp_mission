<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet()//アクセスできるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/'.$catalog->id.'/edit');
        $response->assertOk();
    }

    public function testCanUseForm()//フォームが成立しているか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/'.$catalog->id.'/edit');

        $response->assertSee('action="/mypage/original_catalog/edit_process"')
            ->assertSee('<input id="name" type="text" name="name"                      value="'.$catalog->name.'"  placeholder="山田太郎" required  >')
            ->assertSee('<input id="email" type="email" name="email"                      value="'.$catalog->email.'"  placeholder="example@mail.com" required autocomplete="email" >')
            ->assertSee('<catalog-img-component :err-msgs=\'[]\'  :old-img-num=\'"'.$catalog->img_num.'"')
            ->assertSee('<button type="submit">変更する</button>');
    }
}
