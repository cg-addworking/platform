<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCoursierFrVendorsForJune extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (null == $id = DB::table('enterprises')->whereName('COURSIER.FR')->first()->id ?? null) {
            return;
        }

        $contracts = DB::table('enterprise_user')
            ->select('user_id', 'enterprise_id', 'contract_id')
            ->where('enterprise_id', $id)
            ->whereNotNull('vendor_enterprise_id')
            ->get();

        // mark existing contracts as deleted
        DB::table('contracts')->whereIn('id', $contracts->filter(function ($contract) {
            return $contract->contract_id;
        })->pluck('contract_id')->toArray())->update(['deleted_at' => Carbon\Carbon::now()]);

        // update the relationship contract so a new CPS3 can be signd
        foreach ($contracts as $contract) {
            DB::table('enterprise_user')
                ->where('user_id', $contract->user_id)
                ->where('enterprise_id', $contract->enterprise_id)
                ->where('contract_id', $contract->contract_id)
                ->update(['contract_id' => null]);
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
