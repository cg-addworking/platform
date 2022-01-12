<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionProposalsTableChangeStatusDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $proposals = DB::table('addworking_mission_proposals')->where('status','=','pending')->get();

        foreach ($proposals as $proposal) {
            DB::table('addworking_mission_proposals')->whereId($proposal->id)->update([
                'status' => 'received',
            ]);
        }

        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->string('status')->default('received')->change();
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
            $table->string('status')->default('pending')->change();
        });
    }
}
