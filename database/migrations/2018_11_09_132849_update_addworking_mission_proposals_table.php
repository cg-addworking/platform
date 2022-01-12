<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
        });

        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->uuid('vendor_enterprise_id')->nullable();
            $table->uuid('vendor_user_id')->nullable();

            $table
                ->foreign('vendor_enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('set null');

            $table
                ->foreign('vendor_user_id')
                ->references('id')
                ->on('addworking_user_users')
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
        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->dropColumn('vendor_user_id');
        });

        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->dropColumn('vendor_enterprise_id');
        });

        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->uuid('vendor_id')->nullable();
            $table
                ->foreign('vendor_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('set null');
        });
    }
}
