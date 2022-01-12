<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSogetrelMissionMissionTrackingLineAttachmentsAddAmount extends Migration
{
    public function up()
    {
        Schema::table('sogetrel_mission_mission_tracking_line_attachments', function (Blueprint $table) {
            $table->float('amount')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sogetrel_mission_mission_tracking_line_attachments', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
}
