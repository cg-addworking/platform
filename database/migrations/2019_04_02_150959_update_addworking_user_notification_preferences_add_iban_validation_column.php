<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingUserNotificationPreferencesAddIbanValidationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_user_notification_preferences', function (Blueprint $table) {
            $table->boolean('iban_validation')->default(true)->after('confirmation_vendors_are_paid');
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
            $table->dropColumn('iban_validation');
        });
    }
}
