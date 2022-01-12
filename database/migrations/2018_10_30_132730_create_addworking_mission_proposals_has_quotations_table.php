<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionProposalsHasQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_proposals_has_quotations', function (Blueprint $table) {
            $table->uuid('proposal_id');
            $table->uuid('quotation_id');
            $table->timestamps();

            $table->primary(['proposal_id', 'quotation_id']);

            $table
                ->foreign('proposal_id')
                ->references('id')
                ->on('addworking_mission_proposals')
                ->onDelete('SET NULL');

            $table
                ->foreign('quotation_id')
                ->references('id')
                ->on('addworking_mission_quotations')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_mission_proposals_has_quotations');
    }
}
