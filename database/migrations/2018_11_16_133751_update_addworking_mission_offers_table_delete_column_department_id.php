<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionOffersTableDeleteColumnDepartmentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->uuid('department_id')->nullable();
            $table
                ->foreign('department_id')
                ->references('id')
                ->on('addworking_common_departments')
                ->onDelete('set null');
        });
    }
}
