<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionProposalResponseHasFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_proposal_response_has_files', function (Blueprint $table) {
            $table->uuid('response_id');
            $table->uuid('file_id');
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['response_id', 'file_id']);

            $table
                ->foreign('response_id')
                ->references('id')->on('addworking_mission_proposal_responses')
                ->onDelete('cascade');

            $table
                ->foreign('file_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_mission_proposal_response_has_files');
    }
}
