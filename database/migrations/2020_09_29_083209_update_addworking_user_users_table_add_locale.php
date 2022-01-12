<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingUserUsersTableAddLocale extends Migration
{
    public function up()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->string('locale')->nullable();
        });
    }

    public function down()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dropColumn('locale');
        });
    }
}
