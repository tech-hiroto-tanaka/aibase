<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::query()->truncate();
        $arr = ['フルリモートエリア', '北海道・東北エリア', '関東エリア', '北陸・甲信越エリア', '東海エリア', '関西エリア', '中国・四国エリア', '九州エリア'];
        foreach ($arr as $key => $value) {
            $area = new Area();
            $area->area_name = $value;
            $area->order_number = $key + 1;
            $area->save();
        }
        // Area::where('area_name', 'フルリモートエリア')->delete();
    }
}
