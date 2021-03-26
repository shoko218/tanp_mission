<?php

namespace Tests\Feature\Controller\MyPage\Register_info;

use App\Http\Middleware\TestUserCheck;
use App\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditPassTest extends TestCase
{
    use RefreshDatabase;
    public function testCanGet(){//アクセスできるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info/edit_pass');

        $response->assertOk();
    }

    public function testCanUseForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->get('/mypage/register_info/edit_pass');

        $response->assertSee('action="edit_pass_process"')
            ->assertSee('<input type="password" id="current" name="current_password" required >')
            ->assertSee('<input type="password" id="password" name="new_password" required >')
            ->assertSee('<input type="password" id="confirm" name="new_password_confirmation" required >')
            ->assertSee('<button type="submit">変更する</button>');
    }
}
