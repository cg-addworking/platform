<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionMissionTrackingLinesTableAddingStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
            $table->string('validated_vendor')->default('pending')->change();
            $table->renameColumn('validated_vendor', 'validation_vendor');
        });

        Schema::table('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
            $table->string('validated_customer')->default('pending')->change();
            $table->renameColumn('validated_customer', 'validation_customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
            $table->renameColumn('validation_vendor', 'validated_vendor');
        });

        Schema::table('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
            $table->renameColumn('validation_customer', 'validated_customer');
        });
    }
}
