<?php

use App\Model\Generation;
use App\Model\Genre;
use App\Model\Order;
use App\Model\Order_log;
use App\Model\Prefecture;
use App\Model\Product;
use App\Model\Relationship;
use App\Model\Scene;
use App\User;
use App\Model\Lover;
use App\Model\Event;
use App\Model\Favorite;
use App\Model\Cart;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BaseSeeder::class);
        factory(Product::class,10)->create();
        factory(User::class,5)->create();
        factory(Lover::class,5)->create();
        factory(Event::class,20)->create();
        factory(Order::class,50)->create();
        factory(Order_log::class,80)->create();
        factory(Favorite::class,20)->create();
        factory(Cart::class,15)->create();

        // factory(\App\User::class,200)->create();
        // factory(\App\Model\Lover::class,400)->create();
        // factory(\App\Model\Event::class,600)->create();
        // factory(\App\Model\Order::class,400)->create();
        // factory(\App\Model\Favorite::class,150)->create();
        // factory(\App\Model\Cart::class,150)->create();
        // factory(\App\Model\Order_log::class,600)->create();
        // $faker = Faker\Factory::create'ja_JP');
        // for($scene = 1;$scene < 18;$scene++){
        //     Order::create([
        //         'user_id'=>$faker->numberBetween(1, 200),
        //         'lover_id'=>null,
        //         'scene_id'=>$scene,
        //         'forwarding_last_name' => $faker->lastName ,
        //         'forwarding_first_name' => $faker->firstName ,
        //         'forwarding_last_name_furigana' => $faker->lastKanaName ,
        //         'forwarding_first_name_furigana' => $faker->firstKanaName ,
        //         'forwarding_postal_code'=>$faker->postcode,
        //         'forwarding_prefecture_id'=>$faker->numberBetween(1, 47),
        //         'forwarding_address'=>$faker->city.$faker->streetAddress,
        //         'forwarding_telephone'=>str_replace('-','',$faker->phoneNumber),
        //         'gender'=>null,
        //         'generation_id'=>null,
        //         'relationship_id'=>null,
        //         'user_last_name' =>$faker->lastName ,
        //         'user_first_name' =>$faker->firstName ,
        //         'user_last_name_furigana' =>$faker->lastKanaName ,
        //         'user_first_name_furigana' =>$faker->firstKanaName ,
        //         'user_postal_code'=>$faker->postcode,
        //         'user_prefecture_id'=>$faker->numberBetween(1, 47),
        //         'user_address'=>$faker->city.$faker->streetAddress,
        //         'user_telephone'=>str_replace('-','',$faker->phoneNumber),
        //         'user_email'=> $faker->unique()->safeEmail,
        //     ]);
        // }
        // for($gender = 0;$gender < 3;$gender++){
        //     Order::create([
        //         'user_id'=>$faker->numberBetween(1, 200),
        //         'lover_id'=>null,
        //         'scene_id'=>null,
        //         'forwarding_last_name' => $faker->lastName ,
        //         'forwarding_first_name' => $faker->firstName ,
        //         'forwarding_last_name_furigana' => $faker->lastKanaName ,
        //         'forwarding_first_name_furigana' => $faker->firstKanaName ,
        //         'forwarding_postal_code'=>$faker->postcode,
        //         'forwarding_prefecture_id'=>$faker->numberBetween(1, 47),
        //         'forwarding_address'=>$faker->city.$faker->streetAddress,
        //         'forwarding_telephone'=>str_replace('-','',$faker->phoneNumber),
        //         'gender'=>$gender,
        //         'generation_id'=>null,
        //         'relationship_id'=>null,
        //         'user_last_name' =>$faker->lastName ,
        //         'user_first_name' =>$faker->firstName ,
        //         'user_last_name_furigana' =>$faker->lastKanaName ,
        //         'user_first_name_furigana' =>$faker->firstKanaName ,
        //         'user_postal_code'=>$faker->postcode,
        //         'user_prefecture_id'=>$faker->numberBetween(1, 47),
        //         'user_address'=>$faker->city.$faker->streetAddress,
        //         'user_telephone'=>str_replace('-','',$faker->phoneNumber),
        //         'user_email'=> $faker->unique()->safeEmail,
        //     ]);
        // }
        // for($age = 1;$age < 11;$age++){
        //     Order::create([
        //         'user_id'=>$faker->numberBetween(1, 200),
        //         'lover_id'=>null,
        //         'scene_id'=>null,
        //         'forwarding_last_name' => $faker->lastName ,
        //         'forwarding_first_name' => $faker->firstName ,
        //         'forwarding_last_name_furigana' => $faker->lastKanaName ,
        //         'forwarding_first_name_furigana' => $faker->firstKanaName ,
        //         'forwarding_postal_code'=>$faker->postcode,
        //         'forwarding_prefecture_id'=>$faker->numberBetween(1, 47),
        //         'forwarding_address'=>$faker->city.$faker->streetAddress,
        //         'forwarding_telephone'=>str_replace('-','',$faker->phoneNumber),
        //         'gender'=>null,
        //         'generation_id'=>$age,
        //         'relationship_id'=>null,
        //         'user_last_name' =>$faker->lastName ,
        //         'user_first_name' =>$faker->firstName ,
        //         'user_last_name_furigana' =>$faker->lastKanaName ,
        //         'user_first_name_furigana' =>$faker->firstKanaName ,
        //         'user_postal_code'=>$faker->postcode,
        //         'user_prefecture_id'=>$faker->numberBetween(1, 47),
        //         'user_address'=>$faker->city.$faker->streetAddress,
        //         'user_telephone'=>str_replace('-','',$faker->phoneNumber),
        //         'user_email'=> $faker->unique()->safeEmail,
        //     ]);
        // }
        // for($relation = 1;$relation < 15;$relation++){
        //     Order::create([
        //         'user_id'=>$faker->numberBetween(1, 200),
        //         'lover_id'=>null,
        //         'scene_id'=>null,
        //         'forwarding_last_name' => $faker->lastName ,
        //         'forwarding_first_name' => $faker->firstName ,
        //         'forwarding_last_name_furigana' => $faker->lastKanaName ,
        //         'forwarding_first_name_furigana' => $faker->firstKanaName ,
        //         'forwarding_postal_code'=>$faker->postcode,
        //         'forwarding_prefecture_id'=>$faker->numberBetween(1, 47),
        //         'forwarding_address'=>$faker->city.$faker->streetAddress,
        //         'forwarding_telephone'=>str_replace('-','',$faker->phoneNumber),
        //         'gender'=>null,
        //         'generation_id'=>null,
        //         'relationship_id'=>$relation,
        //         'user_last_name' =>$faker->lastName ,
        //         'user_first_name' =>$faker->firstName ,
        //         'user_last_name_furigana' =>$faker->lastKanaName ,
        //         'user_first_name_furigana' =>$faker->firstKanaName ,
        //         'user_postal_code'=>$faker->postcode,
        //         'user_prefecture_id'=>$faker->numberBetween(1, 47),
        //         'user_address'=>$faker->city.$faker->streetAddress,
        //         'user_telephone'=>str_replace('-','',$faker->phoneNumber),
        //         'user_email'=> $faker->unique()->safeEmail,
        //     ]);
        // }
        // $counts = array(
        //     [0,5,5,5,1,2,8,0,0,0,3,
        //        2,7,8,3,2,2,0,0,3,8,
        //        5,12,0,2,1,9,7,8,11,6,
        //        10,7,6,5,5,1,1,4,6,0,
        //        0,0,0,0,0,9,3,6,2,4,
        //        7,1,2,2,1,2,2,8,3,1,
        //        0,0,0,0,8,6,5,4,10,9,
        //        1,1,3,6,5],//誕生日
        //     [0,4,4,4,1,2,1,0,0,0,0,
        //        0,0,0,2,3,0,0,0,3,12,
        //        0,21,0,0,0,32,11,9,8,11,
        //        14,5,6,2,8,0,0,0,0,0,
        //        0,0,0,0,0,13,2,10,1,0,
        //        11,1,2,2,1,1,0,10,0,0,
        //        0,0,0,0,13,4,8,6,12,13,
        //        1,0,5,8,13],//記念日
        //     [0,6,6,6,1,2,8,0,0,0,10,
        //        13,18,16,12,9,3,0,0,0,16,
        //        4,19,0,3,0,13,16,10,14,8,
        //        14,3,19,15,12,0,0,3,6,4,
        //        5,6,3,4,5,16,1,10,1,3,
        //        15,1,2,0,1,1,1,14,1,0,
        //        0,0,3,0,18,12,14,6,16,15,
        //        0,0,0,8,13],//クリスマス
        //     [0,0,0,0,0,0,7,0,1,0,6,
        //        0,6,9,0,0,0,0,0,0,14,
        //        0,0,0,0,0,18,0,0,0,0,
        //        0,0,21,16,23,0,0,0,0,0,
        //        0,0,0,0,0,19,3,17,1,2,
        //        3,1,2,2,1,1,0,8,2,0,
        //        0,0,0,0,19,0,0,0,0,0,
        //        0,0,0,3,15],//バレンタインデー
        //     [0,8,9,7,1,2,0,0,0,0,0,
        //        0,1,1,13,21,0,0,0,3,15,
        //        3,19,0,0,0,18,17,16,17,13,
        //        14,5,6,8,0,0,0,0,0,0,
        //        0,0,0,0,0,17,2,9,1,3,
        //        11,1,2,2,1,1,0,8,0,0,
        //        0,0,6,0,22,4,3,6,16,15,
        //        0,0,0,14,13],//ホワイトデー
        //     [0,4,5,6,1,2,9,1,2,5,8,
        //        3,4,5,10,13,0,0,0,12,25,
        //        0,6,0,3,0,4,21,5,19,4,
        //        18,14,16,12,0,0,0,0,0,0,
        //        0,0,0,0,0,20,2,17,1,3,
        //        18,1,17,2,1,1,1,13,2,4,
        //        7,5,14,13,28,2,1,4,20,12,
        //        0,0,1,7,20],//母の日
        //     [0,0,0,0,0,0,4,13,8,18,12,
        //        7,16,19,0,1,4,7,3,0,14,
        //        0,0,0,13,0,8,0,0,0,0,
        //        0,0,0,0,23,0,0,0,0,0,
        //        0,0,0,0,0,17,3,17,1,2,
        //        3,1,2,2,1,1,0,8,2,1,
        //        1,0,7,1,21,0,0,0,0,0,
        //        0,0,3,3,18],//父の日
        //     [0,0,0,0,0,0,3,14,12,16,5,
        //        0,1,1,0,0,2,0,0,1,15,
        //        0,0,15,4,15,0,7,0,2,0,
        //        0,0,13,16,3,0,0,0,0,0,
        //        0,0,0,0,0,12,1,17,1,1,
        //        13,1,14,2,4,0,0,5,4,2,
        //        5,2,1,3,21,0,0,0,3,0,
        //        20,0,0,2,13],//敬老の日
        //     [0,4,4,4,1,2,18,0,0,3,13,
        //        8,14,18,2,3,0,0,0,3,12,
        //        0,3,0,1,0,12,12,9,18,11,
        //        14,15,16,17,17,0,0,0,0,0,
        //        0,0,0,0,0,17,12,19,1,0,
        //        11,1,9,2,1,13,3,10,4,6,
        //        8,4,3,5,17,4,4,7,16,13,
        //        1,2,5,8,13],//結婚記念日
        //     [0,0,0,0,0,0,9,0,0,0,0,
        //        0,0,0,0,0,13,0,0,0,0,
        //        21,13,0,0,0,0,0,0,0,0,
        //        0,0,0,0,0,21,8,0,0,18,
        //        12,19,13,14,10,3,0,0,0,0,
        //        0,0,0,0,0,1,0,0,0,0,
        //        0,0,0,0,0,0,0,0,0,0,
        //        0,0,0,1,5],//出産祝い
        //     [0,0,0,0,0,0,13,0,0,0,0,
        //        0,8,9,0,0,0,0,0,0,0,
        //        0,0,0,3,0,0,0,0,0,0,
        //        0,0,0,0,0,0,0,0,0,0,
        //        0,0,0,0,0,7,3,10,4,8,
        //        14,4,8,6,7,9,21,7,12,0,
        //        9,7,13,12,23,0,0,0,0,0,
        //        0,3,2,0,0],//結婚祝い
        //     [0,1,1,1,1,1,17,8,2,9,10,
        //        3,8,9,4,3,0,0,0,0,0,
        //        3,2,4,3,0,0,4,2,3,4,
        //        5,4,2,3,4,2,4,1,3,3,
        //        1,1,1,2,1,12,1,4,2,8,
        //        14,4,8,6,7,9,21,7,12,0,
        //        9,7,13,12,23,1,1,1,4,3,
        //        1,1,2,3,7],//お祝い
        //     [0,3,3,2,1,2,8,5,3,4,8,
        //        5,8,9,3,4,3,1,1,7,12,
        //        2,1,1,1,0,0,1,1,2,2,
        //        2,1,2,2,2,0,0,0,0,0,
        //        0,0,0,0,0,6,1,2,0,1,
        //        2,0,4,2,0,1,7,3,1,0,
        //        2,1,5,1,13,0,0,0,6,7,
        //        0,0,0,0,0],//内祝い
        //     [0,3,3,2,1,2,8,5,3,4,8,
        //        5,8,9,3,4,3,1,1,7,12,
        //        2,1,1,1,0,0,1,1,2,2,
        //        2,1,2,2,2,0,0,0,0,0,
        //        0,0,0,0,0,6,1,2,0,1,
        //        2,0,4,2,0,1,7,3,1,0,
        //        2,1,5,1,13,0,0,0,6,7,
        //        0,0,0,0,0],//お礼
        //     [0,0,0,0,0,0,20,16,8,13,17,
        //        3,12,14,7,8,0,0,0,0,12,
        //        0,0,0,0,0,0,0,0,0,0,
        //        0,0,0,0,0,3,0,0,0,0,
        //        0,0,0,0,0,0,0,0,0,0,
        //        0,0,0,0,0,2,13,8,0,0,
        //        0,0,0,0,16,0,0,0,0,0,
        //        0,0,0,2,3],//お歳暮・お中元
        //     [0,5,6,7,3,2,9,4,8,5,10,
        //        5,12,18,5,4,2,0,1,5,12,
        //        3,7,1,2,1,0,4,3,2,5,
        //        5,2,3,6,2,0,0,0,0,0,
        //        0,0,0,0,0,7,0,2,1,2,
        //        1,1,7,4,1,2,7,2,3,1,
        //        1,2,4,1,10,2,1,4,14,2,
        //        0,0,2,4,5],//自分へのご褒美
        //     [0,5,6,7,3,2,9,4,8,5,10,
        //        5,8,9,3,4,3,1,1,7,12,
        //        2,1,1,1,0,0,1,1,2,2,
        //        14,3,19,15,12,0,0,3,6,4,
        //        5,6,3,4,5,16,1,10,1,3,
        //        15,1,2,0,1,1,1,14,1,0,
        //        9,7,13,12,23,1,1,1,4,3,
        //        1,2,5,8,13],//その他
		// 	[0,5,5,5,1,2,22,27,21,34,26,
		// 	   9,30,37,3,3,8,7,3,4,51,
		// 	   5,12,15,19,16,35,14,8,13,6,
		// 	   10,7,40,37,54,1,1,4,6,0,
		// 	   0,0,0,0,0,57,10,57,5,9,
		// 	   26,4,20,8,7,4,2,29,11,4,
		// 	   6,2,8,4,69,6,5,4,13,9,
		// 	   21,1,6,14,51],//男
		// 	[0,17,19,18,3,6,20,15,14,21,16,
		// 	   5,13,15,26,36,4,0,0,19,63,
		// 	   8,37,15,9,16,31,52,29,49,23,
		// 	   42,26,41,41,8,1,1,4,6,0,
		// 	   0,0,0,0,0,58,8,49,5,11,
		// 	   49,4,35,8,7,4,3,34,9,7,
		// 	   12,7,21,16,79,12,9,14,49,36,
		// 	   21,1,4,29,51],//女
		// 	[0,6,6,5,1,2,10,9,7,11,9,
		// 	   3,12,15,6,8,3,2,1,3,24,
		// 	   4,14,5,7,5,20,12,10,13,8,
		// 	   11,6,17,16,19,0,0,2,4,0,
		// 	   0,0,0,0,0,27,5,24,2,5,
		// 	   14,2,8,4,3,2,1,15,4,1,
		// 	   2,0,4,1,33,5,4,4,13,11,
		// 	   7,0,3,11,23],//その他
        //     [0,0,0,0,0,0,9,0,0,0,0,
        //        0,0,0,0,0,13,0,0,0,0,
        //        21,13,0,0,0,0,0,0,0,0,
        //        0,0,0,0,0,21,8,0,0,18,
        //        12,19,13,14,10,3,0,0,0,0,
        //        0,0,0,0,0,1,0,0,0,0,
        //        0,0,0,0,0,0,0,0,0,0,
        //        0,0,0,1,5],//10以下
		// 	[0,4,4,3,0,1,7,0,1,0,6,
		// 	   0,6,9,6,10,0,0,0,1,21,
		// 	   1,9,0,0,0,27,8,8,8,6,
		// 	   7,2,24,20,23,0,0,0,0,0,
		// 	   0,0,0,0,0,27,4,21,1,3,
		// 	   8,1,3,3,1,1,0,12,2,0,
		// 	   0,0,3,0,30,2,1,3,8,7,
		// 	   0,0,0,10,21],//10
		// 	[0,8,10,9,2,2,24,2,6,3,14,
		// 	   3,22,30,12,16,1,0,0,5,36,
		// 	   4,17,0,3,0,36,14,12,12,12,
		// 	   12,4,34,30,32,14,6,2,4,12,
		// 	   8,12,8,9,6,46,7,36,5,11,
		// 	   21,5,14,10,7,9,18,22,12,0,
		// 	   6,6,15,8,62,4,2,6,20,11,
		// 	   0,2,2,16,32],//20
		// 	[0,6,6,5,1,3,28,2,1,3,12,
		// 	   7,18,22,4,4,9,0,0,6,16,
		// 	   14,14,0,3,0,10,10,9,15,9,
		// 	   13,11,12,12,12,11,4,2,3,9,
		// 	   6,9,6,7,5,21,9,18,3,6,
		// 	   17,3,11,6,4,13,16,14,10,3,
		// 	   9,6,10,9,30,5,4,5,16,14,
		// 	   1,3,5,7,11],//30
		// 	[0,5,5,6,1,2,15,5,4,10,14,
		// 	   8,16,20,6,7,2,2,1,7,23,
		// 	   2,8,0,7,0,13,16,8,19,8,
		// 	   16,14,15,13,18,0,0,1,2,0,
		// 	   0,0,0,0,0,25,8,23,2,3,
		// 	   15,1,12,3,1,6,2,15,4,4,
		// 	   6,3,9,7,29,4,4,6,18,13,
		// 	   0,1,4,9,22],//40
		// 	[0,3,3,4,0,1,12,5,4,10,13,
		// 	   7,13,16,4,6,1,2,1,6,20,
		// 	   0,3,0,6,0,9,13,5,14,6,
		// 	   12,11,12,11,16,0,0,0,0,0,
		// 	   0,0,0,0,0,21,6,21,1,2,
		// 	   12,1,11,2,1,6,1,12,3,4,
		// 	   6,3,9,7,26,2,2,4,14,10,
		// 	   0,0,3,7,20],//50
		// 	[0,0,0,0,0,1,11,9,7,14,12,
		// 	   6,11,14,4,5,2,2,1,5,22,
		// 	   0,3,5,7,5,8,13,4,13,5,
		// 	   10,9,15,15,14,0,0,0,0,0,
		// 	   0,0,0,0,0,22,6,23,1,2,
		// 	   15,1,14,2,2,5,1,12,4,4,
		// 	   7,3,8,7,29,0,0,0,0,0,
		// 	   7,0,3,6,21],//60
		// 	[0,0,0,0,0,0,5,9,7,13,8,
		// 	   3,7,8,3,4,2,2,1,4,18,
		// 	   0,2,5,6,5,4,9,1,7,1,
		// 	   6,4,9,9,8,0,0,0,0,0,
		// 	   0,0,0,0,0,16,2,17,1,2,
		// 	   11,1,11,2,2,0,0,8,2,2,
		// 	   4,2,7,5,23,0,0,0,0,0,
		// 	   6,0,1,4,17],//70
		// 	[0,0,0,0,0,1,7,11,10,16,10,
		// 	   3,7,8,5,7,2,1,0,7,26,
		// 	   0,3,8,7,8,4,15,2,11,2,
		// 	   10,7,16,15,8,0,0,0,0,0,
		// 	   0,0,0,0,0,22,2,23,1,2,
		// 	   18,1,17,2,3,0,0,12,3,3,
		// 	   6,3,10,9,33,1,0,2,12,6,
		// 	   11,0,1,5,23],//80
		// 	[0,0,0,0,0,1,7,10,9,15,9,
		// 	   3,6,7,5,6,2,1,0,6,23,
		// 	   0,3,7,6,7,4,14,2,10,2,
		// 	   9,7,14,14,7,0,0,0,0,0,
		// 	   0,0,0,0,0,20,2,21,1,2,
		// 	   16,1,16,2,2,0,0,11,3,3,
		// 	   6,3,9,8,29,1,0,2,11,6,
		// 	   10,0,1,5,21],//90
        //     [0,18,19,17,3,6,16,0,1,0,16,
        //        13,25,26,27,33,3,0,0,6,57,
        //        7,59,0,3,0,81,44,35,39,32,
        //        42,13,52,41,43,0,0,3,6,4,
        //        5,6,3,4,5,65,8,46,4,8,
        //        40,4,8,6,4,4,1,40,3,0,
        //        0,0,9,0,72,20,25,18,44,43,
        //        1,0,5,33,54],//恋人
        //     [0,12,13,11,2,4,1,0,0,0,0,
        //        0,1,1,15,24,0,0,0,6,27,
        //        3,40,0,0,0,50,28,25,25,24,
        //        28,10,12,10,8,0,0,0,0,0,
        //        0,0,0,0,0,30,4,19,2,3,
        //        22,2,4,4,2,2,0,18,0,0,
        //        0,0,6,0,35,8,11,12,28,28,
        //        1,0,5,22,26],//夫婦
        //     [0,4,5,6,1,2,13,14,10,23,20,
        //        10,20,24,10,14,4,7,3,12,39,
        //        0,6,0,16,0,12,21,5,19,4,
        //        18,14,16,12,23,0,0,0,0,0,
        //        0,0,0,0,0,37,5,34,2,5,
        //        21,2,19,4,2,2,1,21,4,5,
        //        8,5,21,14,49,2,1,4,20,12,
        //        0,0,4,10,38],//親
		// 	[0,14,15,13,3,5,34,8,2,9,13,
		// 	   5,16,18,20,26,15,0,0,6,23,
		// 	   32,46,4,5,1,27,28,26,31,23,
		// 	   29,16,14,16,9,24,13,5,9,21,
		// 	   13,20,14,16,11,41,6,19,5,15,
		// 	   32,6,12,10,9,13,23,23,15,1,
		// 	   9,7,19,12,53,11,9,11,30,27,
		// 	   2,2,5,24,30],//友人
		// 	[0,14,15,13,3,5,34,8,2,9,13,
		// 	   5,16,18,20,26,15,0,0,6,23,
		// 	   32,46,4,5,1,27,28,26,31,23,
		// 	   29,16,14,16,9,24,13,5,9,21,
		// 	   13,20,14,16,11,41,6,19,5,15,
		// 	   32,6,12,10,9,13,23,23,15,1,
		// 	   9,7,19,12,53,11,9,11,30,27,
		// 	   2,2,5,24,30],//兄弟姉妹
		// 	[0,1,1,1,0,0,5,9,7,11,6,
		// 	   2,5,5,2,2,2,1,0,3,15,
		// 	   0,3,7,5,7,3,8,2,6,1,
		// 	   4,3,10,10,6,0,0,0,1,0,
		// 	   0,0,0,0,0,13,1,15,1,2,
		// 	   11,1,10,2,2,0,0,7,3,2,
		// 	   3,1,4,3,20,1,1,1,6,3,
		// 	   10,0,1,3,13],//祖父母
		// 	[0,6,6,6,1,2,13,0,0,0,3,
		// 	   2,8,9,3,2,7,0,0,3,9,
		// 	   14,19,0,2,1,10,8,9,13,7,
		// 	   12,8,7,6,6,9,4,4,7,7,
		// 	   4,7,5,5,4,12,3,7,2,4,
		// 	   8,1,2,2,1,2,2,9,3,1,
		// 	   0,0,0,0,9,7,6,4,12,10,
		// 	   1,1,3,7,8],//子供
		// 	[0,3,3,3,0,1,8,0,0,0,2,
		// 	   1,5,6,2,1,4,0,0,2,6,
		// 	   9,12,0,1,0,6,5,6,8,4,
		// 	   7,5,4,3,3,6,2,3,4,4,
		// 	   3,4,3,3,2,7,2,4,1,3,
		// 	   5,0,1,1,0,1,1,6,2,0,
		// 	   0,0,0,0,6,4,3,3,7,6,
		// 	   0,0,2,4,5,],//孫
        //     [0,5,5,5,1,2,8,0,0,0,3,
        //        2,7,8,3,2,2,0,0,3,8,
        //        5,12,0,2,1,9,7,8,11,6,
        //        10,7,6,5,5,1,1,4,6,0,
        //        0,0,0,0,0,9,3,6,2,4,
        //        7,1,2,2,1,2,2,8,3,1,
        //        0,0,0,0,8,6,5,4,10,9,
        //        1,1,3,6,5],//親戚
		// 	[0,3,3,2,1,1,15,4,1,4,7,
		// 	   3,10,11,3,3,1,0,0,3,6,
		// 	   3,5,1,3,0,3,4,3,5,4,
		// 	   5,4,3,3,3,1,1,1,3,1,
		// 	   0,0,0,0,0,11,2,7,2,7,
		// 	   12,3,7,5,5,7,17,8,9,0,
		// 	   6,5,10,8,22,2,2,1,6,6,
		// 	   0,1,2,3,4,],//上司
		// 	[0,3,3,2,1,1,15,4,1,4,7,
		// 	   3,10,11,3,3,1,0,0,3,6,
		// 	   3,5,1,3,0,3,4,3,5,4,
		// 	   5,4,3,3,3,1,1,1,3,1,
		// 	   0,0,0,0,0,11,2,7,2,7,
		// 	   12,3,7,5,5,7,17,8,9,0,
		// 	   6,5,10,8,22,2,2,1,6,6,
		// 	   0,1,2,3,4],//同僚
 		// 	[0,2,2,2,0,1,11,3,1,3,5,
		// 	   2,7,8,2,2,1,0,0,2,5,
		// 	   2,3,1,2,0,2,3,2,4,3,
		// 	   4,3,2,2,2,0,1,1,2,0,
		// 	   0,0,0,0,0,8,2,5,2,5,
		// 	   9,2,5,4,3,5,12,6,7,0,
		// 	   5,3,7,6,16,1,1,1,5,4,
		// 	   0,1,1,2,3],//部下
		// 	[0,2,2,2,0,1,7,1,0,1,2,
		// 	   1,3,3,1,1,3,0,0,1,4,
		// 	   5,9,0,1,0,8,4,3,4,4,
		// 	   5,3,2,2,3,4,2,1,1,4,
		// 	   2,4,2,3,2,7,1,4,1,2,
		// 	   6,1,2,2,1,2,4,5,3,0,
		// 	   1,1,2,2,8,2,2,2,5,5,
		// 	   0,0,2,3,6],//その他
        //     [0,5,6,7,3,2,9,4,8,5,10,
        //        5,12,18,5,4,2,0,1,5,12,
        //        3,7,1,2,1,0,4,3,2,5,
        //        5,2,3,6,2,0,0,0,0,0,
        //        0,0,0,0,0,7,0,2,1,2,
        //        1,1,7,4,1,2,7,2,3,1,
        //        1,2,4,1,10,2,1,4,14,2,
        //        0,0,2,4,5],//自分
        // );
        // for($index = 0;$index < 44;$index++){
        //     for($product_id = 1;$product_id < 76;$product_id++){
        //         if($counts[$index][$product_id]==0)continue;
        //         $order_log = new Order_log;
        //         $order_log->order_id = $index+1541;
        //         $order_log->product_id = $product_id;
        //         $order_log->count = $counts[$index][$product_id];
        //         $order_log->save();
        //     }
        // }
    }
}
