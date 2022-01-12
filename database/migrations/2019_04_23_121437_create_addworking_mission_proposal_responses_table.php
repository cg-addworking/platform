<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionProposalResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_proposal_responses', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('proposal_id');
            $table->string('status')->default('pending');
            $table->datetime('starts_at')->nullable();
            $table->datetime('ends_at')->nullable();
            $table->float('amount')->default(0);
            $table->datetime('valid_from')->nullable();
            $table->datetime('valid_until')->nullable();
            $table->uuid('accepted_by')->nullable();
            $table->datetime('accepted_at')->nullable();
            $table->uuid('refused_by')->nullable();
            $table->datetime('refused_at')->nullable();
            $table->uuid('created_by');
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('proposal_id')
                ->references('id')->on('addworking_mission_proposals')
                ->onDelete('cascade');

            $table
                ->foreign('accepted_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');

            $table
                ->foreign('refused_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');

            $table
                ->foreign('created_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');

            $table
                ->foreign('deleted_by')
                ->references('id')->on('addworking_user_users')
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
        Schema::dropIfExists('addworking_mission_proposal_responses');
    }
}
