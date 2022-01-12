<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMissionTrackingLineAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sogetrel_mission_mission_tracking_line_attachments', function (Blueprint $table) {
            $table->boolean('created_from_airtable')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sogetrel_mission_mission_tracking_line_attachments', function (Blueprint $table) {
            $table->dropColumn('created_from_airtable');
        });
    }
}
