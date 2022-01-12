<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingMissionOffersAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->uuid('workfield_id')->nullable();

            $table
                ->foreign('workfield_id')
                ->references('id')
                ->on('addworking_enterprise_work_fields')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->dropColumn('workfield_id');
        });
    }
}
