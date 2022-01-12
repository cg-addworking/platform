<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionProposalResponsesTableRenameTotalAmountField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->renameColumn('total_amount', 'quantity');
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
            $table->renameColumn('quantity', 'total_amount');
        });
    }
}
