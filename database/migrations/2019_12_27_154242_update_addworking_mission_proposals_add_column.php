<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingMissionProposalsAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->uuid('file_id')->nullable();

            $table
                ->foreign('file_id')
                ->references('id')
                ->on('addworking_common_files')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->dropColumn('file_id')->nullable();
        });
    }
}
