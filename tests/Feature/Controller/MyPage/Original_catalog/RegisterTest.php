<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/register');

        $response->assertOk();
    }

    public function testCanUseForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');//戻す
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/mypage/original_catalog/register');

        $response->assertSee('action="register_process"')
            ->assertSee('<input id="name" type="text" name="name" value="" placeholder="山田太郎" required  >')
            ->assertSee('<input id="email" type="email" name="email" value="" placeholder="example@mail.com" required autocomplete="email" >')
            ->assertSee('<catalog-img-component :err-msgs=\'[]\'  :old-img-num=\'"0"\' ></catalog-img-component>')
            ->assertSee('<button type="submit">登録</button>');
    }
}
