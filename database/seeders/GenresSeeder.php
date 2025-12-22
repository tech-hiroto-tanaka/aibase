<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::query()->truncate();
        $arr = ['Webアプリ開発', '業務アプリ業務', 'インフラ/運用/基盤系', 'PM/PMO/コンサルなど', 'VB/VBA', '汎用機系', '組込系/制御系'];
        foreach ($arr as $key => $value) {
            $genre = new Genre();
            $genre->genre_name = $value;
            $genre->order_number = $key + 1;
            $genre->save();
        }
        //
    }
}
