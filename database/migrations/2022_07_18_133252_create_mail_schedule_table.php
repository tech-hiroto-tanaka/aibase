<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_schedule', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mail_template_id')->nullable();
            $table->string('mail_from_user_name');
            $table->string('mail_from_user_email')->nullable();
            $table->string('mail_subject');
            $table->string('mail_body');
            $table->string('mail_reply_to_email');
            $table->bigInteger('mail_send_number')->default(0);
            $table->dateTime('mail_send_datetime');
            $table->string('mail_send_file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->longText('mail_condition')->nullable();
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
        Schema::dropIfExists('mail_schedule');
    }
}
