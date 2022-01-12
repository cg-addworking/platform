<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingUserUsersRenameActivationColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->renameColumn('activation_token', 'confirmation_token');
        });

        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->renameColumn('is_active', 'is_confirmed');
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
            $table->renameColumn('is_confirmed','is_active');
        });

        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->renameColumn('confirmation_token', 'activation_token');
        });
    }
}
