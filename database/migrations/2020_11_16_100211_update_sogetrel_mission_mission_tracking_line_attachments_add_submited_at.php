<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSogetrelMissionMissionTrackingLineAttachmentsAddSubmitedAt extends Migration
{
    public function up()
    {
        Schema::table('sogetrel_mission_mission_tracking_line_attachments', function (Blueprint $table) {
            $table->dateTime('submitted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sogetrel_mission_mission_tracking_line_attachments', function (Blueprint $table) {
            $table->dropColumn('submitted_at');
        });
    }
}
