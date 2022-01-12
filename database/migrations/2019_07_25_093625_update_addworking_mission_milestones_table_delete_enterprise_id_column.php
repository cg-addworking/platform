<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionMilestonesTableDeleteEnterpriseIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_milestones', function (Blueprint $table) {
            $table->dropColumn('enterprise_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_milestones', function (Blueprint $table) {
            $table->uuid('enterprise_id')->nullable();
            $table
                ->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });
    }
}
