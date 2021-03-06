<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionProposalResponsesTableAddColumnReasonOfRejection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->string('reason_for_rejection')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->dropColumn('reason_for_rejection');
        });
    }
}
