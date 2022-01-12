<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingUserUsersTableAddColumnsForPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->boolean('is_active')->default(false);
            $table->boolean('is_system_superadmin')->default(false);
            $table->boolean('is_system_admin')->default(false);
            $table->boolean('is_system_operator')->default(false);
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
            $table->dropColumn('is_active');
        });

        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dropColumn('is_system_superadmin');
        });

        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dropColumn('is_system_admin');
        });

        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dropColumn('is_system_operator');
        });
    }
}
