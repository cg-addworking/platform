<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingCommonPassworksHasSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_common_passworks_has_skills', function (Blueprint $table) {
            $table->uuid('passwork_id');
            $table->uuid('skill_id');
            $table->string('level');
            $table->timestamps();
            $table->primary(['passwork_id', 'skill_id']);

            $table->foreign('passwork_id')
                ->references('id')
                ->on('addworking_common_passworks')
                ->onDelete('cascade');

            $table->foreign('skill_id')
                ->references('id')
                ->on('addworking_common_skills')
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
        Schema::dropIfExists('addworking_common_passworks_has_skills');
    }
}
