<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSogetrelMissionMissionTrackingLineAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('sogetrel_mission_mission_tracking_line_attachments', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_tracking_line_id');
            $table->uuid('file_id')->nullable();
            $table->string('num_order')->nullable();
            $table->string('num_attachment')->nullable();
            $table->string('num_site')->nullable();
            $table->datetime('signed_at')->nullable();
            $table->boolean('reverse_charges')->nullable()->comment('autoliquidation');
            $table->boolean('direct_billing')->nullable()->comment('facturation directe');
            $table->timestamps();

            $table->primary('id');
            $table->unique('mission_tracking_line_id', 'line_id_unique');

            $table->foreign('mission_tracking_line_id')
                ->references('id')->on('addworking_mission_mission_tracking_lines')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sogetrel_mission_mission_tracking_line_attachments');
    }
}
