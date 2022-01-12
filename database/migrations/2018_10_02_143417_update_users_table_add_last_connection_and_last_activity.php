<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableAddLastConnectionAndLastActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_activity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dropColumn('last_login');
        });

        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });
    }
}
