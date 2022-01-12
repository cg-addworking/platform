<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddMissionIdToAddworkingContractContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->uuid('mission_id')->nullable();

            $table
                ->foreign('mission_id')
                ->references('id')
                ->on('addworking_mission_missions')
                ->onDelete('SET NULL');
        });

        $missions = DB::table('addworking_mission_missions')
            ->whereNotNull('contract_id')
            ->cursor();

        $contract_ids = DB::table('addworking_mission_missions')
            ->whereNotNull('contract_id')
            ->select('contract_id', DB::raw("COUNT(*) as count"))
            ->groupBy('contract_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('contract_id')
            ->toArray();

        foreach ($missions as $mission) {
            DB::table('addworking_contract_contracts')
                ->whereNotIn('id', $contract_ids)
                ->where('id', $mission->contract_id)
                ->update(['mission_id' => $mission->id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contracts', function (Blueprint $table) {
                $table->dropForeign(['mission_id']);
            });
        }

        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('mission_id');
        });
    }
}
