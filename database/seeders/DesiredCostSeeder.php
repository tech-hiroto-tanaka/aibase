<?php

namespace Database\Seeders;

use App\Models\DesiredCost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesiredCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DesiredCost::query()->truncate();
        $arr = ['40万円以上', '50万円以上', '60万円以上', '70万円以上', '80万円以上', '90万円以上'];
        $min = 40;
        foreach ($arr as $key => $value) {
            $desiredCost = new DesiredCost();
            $desiredCost->desired_cost_name = $value;
            $desiredCost->money = $min + $key * 10;
            $desiredCost->order_number = $key + 1;
            $desiredCost->save();
        }
    }
}
