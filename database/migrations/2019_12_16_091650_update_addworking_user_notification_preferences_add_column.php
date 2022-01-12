<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingUserNotificationPreferencesAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_user_notification_preferences', function (Blueprint $table) {
            $table->boolean('mission_tracking_created')->default('true');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_user_notification_preferences', function (Blueprint $table) {
            $table->dropColumn('mission_tracking_created');
        });
    }
}
