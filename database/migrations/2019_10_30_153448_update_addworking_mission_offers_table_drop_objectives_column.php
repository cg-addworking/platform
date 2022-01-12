<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionOffersTableDropObjectivesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->dropColumn('objectives');
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
            $table->text('objectives')->nullable()->after('description');
        });
    }
}
