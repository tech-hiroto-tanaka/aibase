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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('hira_first_name', 50);
            $table->string('hira_last_name', 50);
            $table->string('kata_first_name', 50);
            $table->string('kata_last_name', 50);
            $table->string('email');
            $table->string('password');
            $table->date('birthday');
            $table->tinyInteger('gender')->default(0);
            $table->string('phone_number', 50);
            $table->tinyInteger('desired_work_type')->nullable();
            $table->date('experience_skills_from_date')->nullable();
            $table->text('experience_skills_detail')->nullable();
            $table->string('nearest_station_name', 255)->nullable();
            $table->text('other_requests')->nullable();
            $table->string('email_verified_token')->nullable();
            $table->datetime('email_verified_token_expire')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('reset_password_token')->nullable();
            $table->datetime('reset_password_token_expire')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
