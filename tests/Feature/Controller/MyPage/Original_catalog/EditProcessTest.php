<?php

namespace Tests\Feature\Controller\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Model\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditProcessTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanPost()//データを変更できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();

        $infos =[
            'catalog_id' => $catalog->id,
            'name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'img_num' => 2,
        ];

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/edit_process',$infos);

        $response->assertRedirect('/mypage/original_catalog/'.$catalog->id)
                ->assertSessionHas('suc_msg','変更しました。');

        $infos['id'] = $infos['catalog_id'];
        unset($infos['catalog_id']);

        $this->assertDatabaseHas('catalogs',$infos);
    }

    public function testCanShowError()//エラーが発生している旨を表示できるか
    {
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();
        $catalog = factory(Catalog::class)->create();

        $infos =[
            'catalog_id' => $catalog->id,
            'name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'img_num' => 2,
        ];

        //既に相手に送信しているカタログを編集しようとしたエラー
        $catalog->did_send_mail = true;
        $catalog->save();

        $response = $this->actingAs($user)
            ->post('/mypage/original_catalog/edit_process',$infos);

        $response->assertRedirect('/mypage/original_catalog/')
                ->assertSessionHas('err_msg','既に相手に送っているカタログは編集できません。');
    }
}
