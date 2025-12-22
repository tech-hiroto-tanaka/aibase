<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('news')->delete();
        
        \DB::table('news')->insert(array (
            0 => 
            array (
                'id' => 1,
                'news_title' => 'new 1',
                'news_content' => 'aaaaaaa',
                'news_url' => NULL,
                'news_file_url' => NULL,
                'news_file_name' => NULL,
                'news_publish_start_datetime' => '2022-06-02 16:47:08',
                'news_publish_end_datetime' => '2022-07-31 16:47:12',
                'news_publish_status' => 1,
                'created_at' => '2022-06-04 16:47:22',
                'updated_at' => '2022-06-04 16:47:25',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'news_title' => 'new 2',
                'news_content' => 'bbbbbb',
                'news_url' => NULL,
                'news_file_url' => NULL,
                'news_file_name' => NULL,
                'news_publish_start_datetime' => '2022-06-02 16:47:35',
                'news_publish_end_datetime' => '2022-09-30 16:47:42',
                'news_publish_status' => 1,
                'created_at' => '2022-06-04 16:47:51',
                'updated_at' => '2022-06-04 16:47:53',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'news_title' => 'new 3',
                'news_content' => 'cccccc',
                'news_url' => NULL,
                'news_file_url' => NULL,
                'news_file_name' => NULL,
                'news_publish_start_datetime' => '2022-06-03 16:48:06',
                'news_publish_end_datetime' => '2022-06-30 16:48:10',
                'news_publish_status' => 1,
                'created_at' => '2022-06-04 16:48:16',
                'updated_at' => '2022-06-04 16:48:19',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}