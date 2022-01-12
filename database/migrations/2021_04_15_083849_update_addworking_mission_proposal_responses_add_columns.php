<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingMissionProposalResponsesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->uuid('proposal_id')->nullable()->change();
            $table->float('quantity')->nullable()->change();
            $table->text('argument')->nullable();
            $table->float('amount_before_taxes')->default(0)->nullable();
            $table->integer('number')->nullable();
            $table->uuid('file_id')->nullable();
            $table->uuid('offer_id')->nullable();

            $table->foreign('file_id')
                  ->references('id')
                  ->on('addworking_common_files')
                  ->onDelete('set null');

            $table->foreign('offer_id')
                  ->references('id')
                  ->on('addworking_mission_offers')
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
            $table->uuid('proposal_id')->change();
            $table->float('quantity')->change();
            $table->dropColumn(['argument', 'amount_before_taxes', 'number', 'file_id', 'offer_id']);
        });
    }
}
