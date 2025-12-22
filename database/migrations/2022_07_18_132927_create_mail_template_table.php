<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_template', function (Blueprint $table) {
            $table->id();
            $table->string('mail_name');
            $table->string('mail_from_user_name');
            $table->string('mail_from_user_email')->nullable();
            $table->string('mail_subject');
            $table->string('mail_body');
            $table->string('mail_reply_to_email');
            $table->string('mail_send_file_path', 500)->nullable();
            $table->string('file_name')->nullable();
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
        Schema::dropIfExists('mail_template');
    }
}
