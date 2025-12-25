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
        Schema::create('operation_logs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('operation_log_datetime');
            $table->string('screen_name')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('operation_name')->nullable();
            $table->tinyInteger('operation_type')->nullable();
            $table->text('operation_value')->nullable(); // JSON or text
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_logs');
    }
};
