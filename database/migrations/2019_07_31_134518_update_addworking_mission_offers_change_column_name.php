<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionOffersChangeColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->renameColumn('starts_at', 'starts_at_desired');
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
            $table->renameColumn('starts_at_desired', 'starts_at');
        });
    }
}
