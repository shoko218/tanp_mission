<?php

namespace Tests\Feature\Controller\Main\Purchase;

use App\Model\Lover;
use App\Model\Prefecture;
use App\Model\Relationship;
use App\Model\Scene;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterInfoToSessionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanStoreRegisterInfoInSession()//セッションに入力した情報を格納できるか
    {
        //未ログイン時
        $this->seed('BaseSeeder');
        $infos =[
            'forwarding_last_name' => $this->faker->lastName,
            'forwarding_first_name' => $this->faker->firstName,
            'forwarding_last_name_furigana' => $this->faker->lastKanaName,
            'forwarding_first_name_furigana' => $this->faker->firstKanaName,
            'forwarding_postal_code' => $this->faker->postcode,
            'forwarding_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'forwarding_address' => $this->faker->city.$this->faker->streetAddress,
            'forwarding_telephone' => str_replace('-','',$this->faker->phoneNumber),
            'gender' => $this->faker->numberBetween(0, 2),
            'relationship_id' => Relationship::inRandomOrder()->first()->id,
            'age' => $this->faker->numberBetween(0, 100),
            'scene_id' => Scene::inRandomOrder()->first()->id,
            // 'lover_id' => null,
            'user_last_name' => $this->faker->lastName,
            'user_first_name' => $this->faker->firstName,
            'user_last_name_furigana' => $this->faker->lastKanaName,
            'user_first_name_furigana' => $this->faker->firstKanaName,
            'user_postal_code' => $this->faker->postcode,
            'user_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'user_address' => $this->faker->city.$this->faker->streetAddress,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_telephone' => str_replace('-','',$this->faker->phoneNumber),
        ];

        $response = $this->post('/purchase/register_to_session',$infos);
        $response->assertRedirect('/purchase/payment')
            ->assertSessionHasAll($infos);

        //ログイン時
        $user = factory(User::class)->create();
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id,
        ]);
        $infos =[
            'forwarding_last_name' => $this->faker->lastName,
            'forwarding_first_name' => $this->faker->firstName,
            'forwarding_last_name_furigana' => $this->faker->lastKanaName,
            'forwarding_first_name_furigana' => $this->faker->firstKanaName,
            'forwarding_postal_code' => $this->faker->postcode,
            'forwarding_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'forwarding_address' => $this->faker->city.$this->faker->streetAddress,
            'forwarding_telephone' => str_replace('-','',$this->faker->phoneNumber),
            'gender' => $this->faker->numberBetween(0, 2),
            'relationship_id' => Relationship::inRandomOrder()->first()->id,
            'age' => $this->faker->numberBetween(0, 100),
            'scene_id' => Scene::inRandomOrder()->first()->id,
            'lover_id' => $lover->id,
            'user_last_name' => $this->faker->lastName,
            'user_first_name' => $this->faker->firstName,
            'user_last_name_furigana' => $this->faker->lastKanaName,
            'user_first_name_furigana' => $this->faker->firstKanaName,
            'user_postal_code' => $this->faker->postcode,
            'user_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'user_address' => $this->faker->city.$this->faker->streetAddress,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_telephone' => str_replace('-','',$this->faker->phoneNumber),
        ];

        $response = $this->actingAs($user)
            ->post('/purchase/register_to_session',$infos);
        $response->assertRedirect('/purchase/payment')
            ->assertSessionHasAll($infos);
    }

     public function testCanShowError()//大切な人の指定にエラーがある場合(自分が作っていないもしくは存在しない)、エラーを返せるか
     {
        $this->seed('BaseSeeder');//戻す
        $other_lover = factory(Lover::class)->create();
        $user = factory(User::class)->create();
        $infos =[
            'forwarding_last_name' => $this->faker->lastName,
            'forwarding_first_name' => $this->faker->firstName,
            'forwarding_last_name_furigana' => $this->faker->lastKanaName,
            'forwarding_first_name_furigana' => $this->faker->firstKanaName,
            'forwarding_postal_code' => $this->faker->postcode,
            'forwarding_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'forwarding_address' => $this->faker->city.$this->faker->streetAddress,
            'forwarding_telephone' => str_replace('-','',$this->faker->phoneNumber),
            'gender' => $this->faker->numberBetween(0, 2),
            'relationship_id' => Relationship::inRandomOrder()->first()->id,
            'age' => $this->faker->numberBetween(0, 100),
            'scene_id' => Scene::inRandomOrder()->first()->id,
            'lover_id' => $other_lover->id,
            'user_last_name' => $this->faker->lastName,
            'user_first_name' => $this->faker->firstName,
            'user_last_name_furigana' => $this->faker->lastKanaName,
            'user_first_name_furigana' => $this->faker->firstKanaName,
            'user_postal_code' => $this->faker->postcode,
            'user_prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'user_address' => $this->faker->city.$this->faker->streetAddress,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_telephone' => str_replace('-','',$this->faker->phoneNumber),
        ];

        $response = $this->actingAs($user)
            ->post('/purchase/register_to_session',$infos);
        $response->assertRedirect('/')
            ->assertSessionHas('err_msg','エラーが発生しました。');

        $infos['lover_id'] = -1;
        $response = $this->actingAs($user)
            ->post('/purchase/register_to_session',$infos);
        $response->assertRedirect('/')
            ->assertSessionHas('err_msg','エラーが発生しました。');
     }
}
