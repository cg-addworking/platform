<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerChargeGuruMissionDetailsDropRequestedSkillsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('requested_skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->json('requested_skills')->nullable();
        });
    }
}
