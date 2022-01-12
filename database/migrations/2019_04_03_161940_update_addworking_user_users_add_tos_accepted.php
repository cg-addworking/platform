<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateAddworkingUserUsersAddTosAccepted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->boolean('tos_accepted')->default(false);
        });

        DB::table('addworking_user_users')->update(['tos_accepted' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dropColumn('tos_accepted');
        });
    }
}
