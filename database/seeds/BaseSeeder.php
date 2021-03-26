<?php

use Illuminate\Database\Seeder;
use App\Model\Generation;
use App\Model\Genre;
use App\Model\Prefecture;
use App\Model\Product;
use App\Model\Relationship;
use App\Model\Scene;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefectures=['北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県'];
        foreach ($prefectures as $prefecture) {
            Prefecture::create(['name' => $prefecture]);
        }

        $relationships=['恋人','配偶者','親','友人','兄弟姉妹','祖父母','子供','孫','親戚','上司','同僚','部下','その他','自分'];
        foreach ($relationships as $relationship) {
            Relationship::create(['name' => $relationship]);
        }

        $genres=['グルメ・スイーツ','小物・文房具','ファッション','ベビー・キッズ','インテリア','キッチン','ビューティー','ギフトカタログ'];
        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }

        $scenes=['誕生日','記念日','クリスマス','バレンタインデー','ホワイトデー','母の日','父の日','敬老の日','結婚記念日','出産祝い','結婚祝い','お祝い','内祝い','お礼','お歳暮・お中元','自分へのご褒美','その他'];
        foreach ($scenes as $scene) {
            Scene::create(['name' => $scene]);
        }

        Generation::create([
            'name' => '10才未満',
            'min_age' => 0,
            'max_age' => 9
        ]);
        for ($i=1; $i < 9; $i++) {
            Generation::create([
                'name' => $i.'0代',
                'min_age' => $i*10,
                'max_age' => $i*10+9
            ]);
        }
        Generation::create([
            'name' => '90代以上',
            'min_age' => 90,
            'max_age' => 200
        ]);
    }
}
