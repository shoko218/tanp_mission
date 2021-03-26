<?php

namespace Tests\Feature\Controller\MyPage\Lovers;

use App\Model\Prefecture;
use App\Model\Relationship;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegisterProcessTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanPost()//データを登録できるか
    {
        $this->seed('BaseSeeder');
        Storage::fake('fake');
        $user = factory(User::class)->create();
        $file_name = 'test.jpeg';
        $file = UploadedFile::fake()->image($file_name);
        $infos =[
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'last_name_furigana' => $this->faker->lastKanaName,
            'first_name_furigana' => $this->faker->firstKanaName,
            'postal_code' => $this->faker->postcode,
            'prefecture_id' => Prefecture::inRandomOrder()->first()->id,
            'address' => $this->faker->city.$this->faker->streetAddress,
            'telephone' => str_replace('-','',$this->faker->phoneNumber),
            'gender' => $this->faker->numberBetween(0, 2),
            'relationship_id' => Relationship::inRandomOrder()->first()->id,
            'birthday' => $this->faker->dateTimeBetween('-90 years', '-15years')->format('Y-m-d'),
            'image' => $file,
        ];
        $response = $this->actingAs($user)
            ->post('/mypage/lovers/register_process',$infos);

        $response->assertRedirect('/mypage/lovers/')
                ->assertSessionHas('suc_msg','追加しました。');

        unset($infos['image']);
        $infos['img_path'] = $file_name;

        $this->assertDatabaseHas('lovers',$infos);

        Storage::disk('fake')->assertExists('/lover_imgs/'.$file_name);
    }
}
