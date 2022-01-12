<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_milestones', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_id');
            $table->uuid('enterprise_id');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('mission_id')
                ->references('id')->on('addworking_mission_missions')
                ->onDelete('cascade');

            $table
                ->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
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
        Schema::dropIfExists('addworking_mission_milestones');
    }
}
