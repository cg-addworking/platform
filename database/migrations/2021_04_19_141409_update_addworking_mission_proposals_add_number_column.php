<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingMissionProposalsAddNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->integer('number')->nullable();
        });

        $proposals = DB::table('addworking_mission_proposals')->get();
        $number = 0;

        foreach ($proposals as $proposal) {
            $number++;
            DB::table('addworking_mission_proposals')
                ->where('id', $proposal->id)
                ->update(['number' => $number]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
