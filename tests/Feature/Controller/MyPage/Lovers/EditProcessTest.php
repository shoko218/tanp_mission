<?php

namespace Tests\Feature\Controller\MyPage\Lovers;

use App\Model\Lover;
use App\Model\Prefecture;
use App\Model\Relationship;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EditProcessTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanPost()//大切な人の情報を登録できるか
    {
        $this->seed('BaseSeeder');
        Storage::fake('fake');
        $user = factory(User::class)->create();

        $file_name = 'test.jpeg';
        $file = UploadedFile::fake()->image($file_name);
        $path=$file->path();
        $image=\Image::make($path);
        $image->fit(480,480,function($constraint){//リサイズ
            $constraint->upsize();
        });
        Storage::disk('fake')->put('/lover_imgs/'.$file_name,(string)$image->encode(),'public');

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
            'img_path' => $file_name,
        ];

        $lover = factory(Lover::class)->create($infos);

        $this->assertDatabaseHas('lovers',$infos);

        Storage::disk('fake')->assertExists('/lover_imgs/'.$file_name);

        $new_file_name = 'new_test.jpeg';
        $new_file = UploadedFile::fake()->image($new_file_name);
        $new_path=$new_file->path();
        $new_image=\Image::make($new_path);
        $new_image->fit(480,480,function($constraint){//リサイズ
            $constraint->upsize();
        });
        Storage::disk('fake')->put('/lover_imgs/'.$new_file_name,(string)$new_image->encode(),'public');

        $new_infos =[
            'lover_id' =>$lover->id,
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
            'image' => $new_file,
        ];

        $response = $this->actingAs($user)
            ->post('/mypage/lovers/edit_process',$new_infos);

        $response->assertRedirect('/mypage/lovers/'.$lover->id)
                ->assertSessionHas('suc_msg','変更しました。');

        unset($new_infos['lover_id']);
        unset($new_infos['image']);
        $new_infos['img_path'] = $new_file_name;
        $new_infos['id'] = $lover->id;

        $this->assertDatabaseHas('lovers',$new_infos);

        Storage::disk('fake')->assertExists('/lover_imgs/'.$new_file_name);
        Storage::disk('fake')->assertMissing('/lover_imgs/'.$file_name);
    }
}
