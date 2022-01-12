<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSogetrelUserPassworkSavedSearchesAddSendingDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sogetrel_user_passwork_saved_searches_scheduled', function (Blueprint $table) {
            $table->dateTime('last_sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sogetrel_user_passwork_saved_searches_scheduled', function (Blueprint $table) {
            $table->dropColumn('last_sent_at');
        });
    }
}
