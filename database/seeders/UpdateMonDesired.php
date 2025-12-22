<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\DesiredCost;
use Illuminate\Database\Seeder;

class UpdateMonDesired extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = Job::get();
        foreach ($jobs as $key => $job) {
            $job->min_desired_costs = DesiredCost::whereIn('id', collect($job->desired_costs)->pluck('id')->all())->min('money');
            $job->save();
        }
    }
}
