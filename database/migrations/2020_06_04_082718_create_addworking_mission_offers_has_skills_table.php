<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingMissionOffersHasSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_offers_has_skills', function (Blueprint $table) {
            $table->uuid('offer_id');
            $table->uuid('skill_id');
            $table->timestamps();

            $table->foreign('offer_id')
                ->references('id')->on('addworking_mission_offers')
                ->onDelete('cascade');

            $table->foreign('skill_id')
                ->references('id')->on('addworking_common_skills')
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
        Schema::dropIfExists('addworking_mission_offers_has_skills');
    }
}
