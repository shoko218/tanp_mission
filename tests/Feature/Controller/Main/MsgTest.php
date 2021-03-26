<?php

namespace Tests\Feature\Controller\Main;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MsgTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet()//アクセスできるか
    {
        $title = 'タイトル';
        $msg = 'メッセージ';
        $response = $this->withSession(['title' => $title,'msg' => $msg])
            ->get('/msg');
        $response->assertOk();
    }

    public function testCanSeeContents(){ //コンテンツが見えているか
        $title = 'タイトル';
        $msg = 'メッセージ';
        $response = $this->withSession(['title' => $title,'msg' => $msg])
            ->get('/msg');
        $response->assertSeeText($title)
            ->assertSeeText($msg);
    }

    public function testCanRedirect(){ //リダイレクトができているか
        $this->seed('BaseSeeder');//戻す
        $title = 'タイトル';
        $msg = 'メッセージ';

        $response = $this->get('/msg');//パラメータなし
        $response->assertRedirect('/');

        $response = $this->withSession(['title' => $title,'msg' => ''])//タイトルだけ
            ->get('/msg');
        $response->assertRedirect('/');

        $response = $this->withSession(['title' => '','msg' => $msg])//メッセージだけ
            ->get('/msg');
        $response->assertRedirect('/');
    }
}
