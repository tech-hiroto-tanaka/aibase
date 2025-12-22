<?php

namespace Database\Seeders;

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
        $this->call(UserSeeder::class);
        $this->call(GenresSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(PrefectureSeeder::class);
        $this->call(DesiredCostSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(SkillSeeder::class);
        // \App\Models\User::factory(10)->create();
        $this->call(JobsTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(MailMasterSeeder::class);
    }
}
