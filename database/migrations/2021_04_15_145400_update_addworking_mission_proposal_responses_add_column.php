<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingMissionProposalResponsesAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->uuid('enterprise_id')->nullable();

            $table->foreign('enterprise_id')
                  ->references('id')
                  ->on('addworking_enterprise_enterprises')
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
        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->dropColumn('enterprise_id');
        });
    }
}
