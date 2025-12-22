<?php

namespace Database\Seeders;

use App\Models\MailMaster;
use Illuminate\Database\Seeder;

class MailMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailMaster::query()->truncate();
        $arr = [
            [
                'key' => '#SEND_DATE#',
                'label' => '送信日'
            ],
            [
                'key' => '#SEND_TIME#',
                'label' => '送信時間'
            ],
            [
                'key' => '#USER_ID#',
                'label' => 'ユーザーID'
            ],
            [
                'key' => '#USER_NAME#',
                'label' => 'ユーザー名'
            ],
            [
                'key' => '#USER_NAME_KANA#',
                'label' => 'ユーザー名（フリガナ）'
            ],
            [
                'key' => '#GENDER#',
                'label' => '性別'
            ],
            [
                'key' => '#BIRTH_DAY#',
                'label' => '生年月日'
            ],
            [
                'key' => '#USER_EMAIL#',
                'label' => 'ユーザーのメールアドレス'
            ],
            [
                'key' => '#USER_PHONE#',
                'label' => 'ご連絡先電話番号'
            ],
            [
                'key' => '#USER_AREA#',
                'label' => 'お住いのエリア'
            ],
            [
                'key' => '#USER_HOPE_JOB_TIME#',
                'label' => '希望就業時期'
            ],
            [
                'key' => '#USER_EXPERIENCE_SKILL#',
                'label' => '経験スキル'
            ],
            [
                'key' => '#USER_NEAR_STATION#',
                'label' => '最寄駅'
            ]
        ];
        foreach ($arr as $key => $item) {
            $master = new MailMaster();
            foreach ($item as $col => $value) {
                $master->{$col} = $value;
            }
            $master->save();
        }
        //
    }
}
