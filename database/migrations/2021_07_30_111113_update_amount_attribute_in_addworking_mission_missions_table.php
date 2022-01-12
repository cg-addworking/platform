<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAmountAttributeInAddworkingMissionMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $missions = DB::table('addworking_mission_missions')->cursor();

        foreach ($missions as $mission) {
            $calculated_amount = $mission->quantity * $mission->unit_price;

            if ($calculated_amount !== 0) {
                $mission->amount = $calculated_amount;

                DB::table('addworking_mission_missions')->where('id', $mission->id)
                    ->update(['amount' => $calculated_amount]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
