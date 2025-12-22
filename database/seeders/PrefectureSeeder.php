<?php

namespace Database\Seeders;

use App\Models\Prefecture;
use App\Models\AreaPrefecture;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class PrefectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Prefecture::query()->truncate();
        AreaPrefecture::query()->truncate();
        $prefectures = [
            ['フルリモート'],
            ['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県'],
            ['東京都', '神奈川県', '埼玉県', '千葉県', '茨城県', '栃木県', '群馬県'],
            ['新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県'],
            ['愛知県', '岐阜県', '静岡県', '三重県'],
            ['大阪府', '兵庫県', '京都府', '滋賀県', '奈良県', '和歌山県'],
            ['鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県'],
            ['福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県']
        ];
        foreach ($prefectures as $key => $prefecture) {
            foreach ($prefecture as $keyPref => $item) {
                $pref = new Prefecture();
                $pref->prefecture_name = $item;
                $pref->order_number = $keyPref + 1;
                $pref->area_id = $key + 1;
                $pref->save();
                $areaPref = new AreaPrefecture();
                $areaPref->area_id = $key + 1;
                $areaPref->prefecture_id = $pref->id;
                $areaPref->save();
            }
        }
    }
}
