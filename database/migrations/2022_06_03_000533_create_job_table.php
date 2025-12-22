<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_code');
            $table->string('job_name');
            $table->string('job_cost')->nullable();
            $table->text('job_match_skill')->nullable();
            $table->string('job_period')->nullable();
            $table->tinyInteger('type_of_job')->nullable();
            $table->text('office_towns')->nullable();
            $table->json('genres')->nullable();
            $table->json('areas')->nullable();
            $table->json('skills')->nullable();
            $table->json('desired_costs')->nullable();
            $table->json('features')->nullable();
            $table->dateTime('job_publish_start_date')->nullable();
            $table->dateTime('job_publish_end_date')->nullable();
            $table->tinyInteger('job_publish_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
