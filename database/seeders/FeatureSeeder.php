<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::query()->truncate();
        $arr = ['担当者オススメ案件', 'エンド直', '元請け直', 'スタートアップ', '高単価', '短期案件', '長期案件', '週1〜4可',
            'リモート可', '時短勤務可', '稼働安定', '駅近く', '車通勤可', '20代活躍中', '女性多数活躍中', '私服/ビジネスカジュアル可',
            '最新技術', '外国語を活かせる', '4月スタート案件'];
        foreach ($arr as $key => $value) {
            $feature = new Feature();
            $feature->feature_name = $value;
            $feature->order_number = $key + 1;
            $feature->save();
        }
    }
}
