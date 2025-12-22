<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::query()->truncate();
        $arr = ['Java', 'C言語', 'C＋＋', 'VC++', 'VB/VBA', '.NET（VB/C#）', 'Augular .js /Node.js', 'React',
            'SQL', 'JavaScript', 'PHP', 'Perl', 'Ruby', 'Python', 'Shell（C \B/K）', '私服/iOS', 'Android', 'Objective-C',
            'Swift', 'Kotlin', 'HTML5', 'データベース', 'アセンブラ', 'COBOL', 'インフラ（サーバー）', 'インフラ（ネットワーク）', 'インフラ（その他）',
            'PM', 'PMO', 'コンサルティング', 'ITアーキテクト', 'DX', 'テスト/検証', 'Webディレクター', 'ERP', 'AWS', 'Azure',
            'GCP', 'パブリッククラウド', 'ゲーム', 'Unity', 'Scale', 'Golang', 'RPA', 'Chef', 'Puppet', 'Ansible', 'Iot', 'AI・機械学習', 'その他言語'];
        foreach ($arr as $key => $value) {
            $skill = new Skill();
            $skill->skill_name = $value;
            $skill->order_number = $key + 1;
            $skill->save();
        }
    }
}
