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
        Schema::create('area_prefectures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('prefecture_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('prefecture_id')->references('id')->on('prefectures')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_prefectures');
    }
};
