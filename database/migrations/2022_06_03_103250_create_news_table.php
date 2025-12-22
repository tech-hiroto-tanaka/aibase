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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('news_title');
            $table->text('news_content');
            $table->string('news_url')->nullable();
            $table->string('news_file_url')->nullable();
            $table->string('news_file_name')->nullable();
            $table->dateTime('news_publish_start_datetime');
            $table->dateTime('news_publish_end_datetime');
            $table->tinyInteger('news_publish_status')->default(0);
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
        Schema::dropIfExists('news');
    }
};
