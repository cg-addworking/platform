<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerChargeGuruMissionDetailsSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_charge_guru_mission_details_skills', function (Blueprint $table) {
            $table->uuid('mission_detail_id');
            $table->uuid('skill_id');
            $table->timestamps();
            $table->primary(['mission_detail_id', 'skill_id']);

            $table
                ->foreign('mission_detail_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details')
                ->onDelete('cascade');

            $table
                ->foreign('skill_id')
                ->references('id')
                ->on('customer_charge_guru_skills')
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
        Schema::dropIfExists('customer_charge_guru_mission_details_skills');
    }
}
