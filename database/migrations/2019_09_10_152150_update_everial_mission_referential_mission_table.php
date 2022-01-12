<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEverialMissionReferentialMissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('everial_mission_referential_missions', function (Blueprint $table) {
            $table->renameColumn('kilometer', 'distance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('everial_mission_referential_missions', function (Blueprint $table) {
            $table->renameColumn('distance', 'kilometer');
        });
    }
}
