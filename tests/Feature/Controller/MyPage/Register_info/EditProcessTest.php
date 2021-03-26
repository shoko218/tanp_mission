<?php

namespace Tests\Feature\Controller\MyPage\Register_info;

use App\Http\Middleware\TestUserCheck;
use App\Model\Prefecture;
use App\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditProcessTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanPost(){//登録できるか
        $this->seed('BaseSeeder');
        $user = factory(User::class)->create();

        $infos =[
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'last_name_furigana' => $this->faker->lastKanaName,
            'first_name_furigana' => $this->faker->firstKanaName,
            'birthday' => $this->faker->dateTimeBetween('-40 years', '-15years')->format('Y-m-d'),
            'gender'=>$this->faker->numberBetween(0, 2),
            'postal_code'=>$this->faker->postcode,
            'prefecture_id'=>Prefecture::inRandomOrder()->first()->id,
            'address'=>$this->faker->city.$this->faker->streetAddress,
            'telephone' => str_replace('-','',$this->faker->phoneNumber),
        ];

        $response = $this->withoutMiddleware([TestUserCheck::class, RequirePassword::class])
            ->actingAs($user)
            ->post('/mypage/register_info/edit_process',$infos);

        $response->assertRedirect('/mypage/register_info')
            ->assertSessionHas('suc_msg','登録情報を変更しました。');

        $this->assertDatabaseHas('users',$infos);
    }
}
