<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionProposalResponsesTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->float('unit_price')->nullable();
            $table->string('unit')->nullable();
        });

        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->renameColumn('amount', 'total_amount');
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
            $table->dropColumn('unit_price');
        });

        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->dropColumn('unit');
        });

        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->renameColumn('total_amount', 'amount');
        });
    }
}
