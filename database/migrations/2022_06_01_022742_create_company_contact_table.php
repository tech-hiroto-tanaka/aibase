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
        Schema::create('company_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('department_name');
            $table->string('contact_hira_first_name');
            $table->string('contact_hira_last_name');
            $table->string('contact_kata_first_name');
            $table->string('contact_kata_last_name');
            $table->string('contact_phone_number');
            $table->string('contact_email');
            $table->bigInteger('area_id');
            $table->text('contact_content');
            $table->string('contact_agent');
            $table->string('contact_ip');
            $table->tinyInteger('contact_type')->default(0);
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
        Schema::dropIfExists('company_contacts');
    }
};
