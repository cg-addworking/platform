<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionMissionsTableAddProposalResponseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->uuid('proposal_response_id')->nullable();

            $table
                ->foreign('proposal_response_id')
                ->references('id')
                ->on('addworking_mission_proposal_responses')
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
        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->dropColumn('proposal_response_id');
        });
    }
}
