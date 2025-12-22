<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKataLastNameToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
            $table->string('hira_last_name')->after('contact_hira_name');
            $table->string('kata_last_name')->after('contact_kata_name');
            $table->renameColumn('contact_hira_name', 'hira_first_name');
            $table->renameColumn('contact_kata_name', 'kata_first_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
}
