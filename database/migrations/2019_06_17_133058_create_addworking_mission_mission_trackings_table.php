<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionMissionTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_mission_trackings', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->uuid('mission_id');
            $table->uuid('milestone_id');
            $table->uuid('user_id')->nullable();
            $table->string('status');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('mission_id')
                ->references('id')->on('addworking_mission_missions')
                ->onDelete('cascade');

            $table
                ->foreign('user_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('cascade');

            $table
                ->foreign('milestone_id')
                ->references('id')->on('addworking_mission_milestones')
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
        Schema::dropIfExists('addworking_mission_mission_trackings');
    }
}
