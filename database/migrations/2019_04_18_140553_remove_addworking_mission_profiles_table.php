<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAddworkingMissionProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('addworking_mission_profiles');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('addworking_mission_profiles', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_id');

            $table->string('job');
            $table->string('region');
            $table->string('mobility');
            $table->string('skills');
            $table->boolean('should_provide_recommendations');
            $table->integer('years_of_experience');
            $table->string('diploma');
            $table->string('languages');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->foreign('mission_id')->references('id')->on('addworking_mission_missions')->onDelete('cascade');
        });
    }
}
