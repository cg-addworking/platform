<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingContractContractsTableAddData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $items = DB::table('addworking_enterprise_enterprises_has_users')
            ->whereNotNull('contract_id')
            ->get();

        foreach ($items as $item) {
            DB::table('contracts')->where('id', $item->contract_id)
                ->update([
                    'vendor_id'   => $item->vendor_enterprise_id,
                    'customer_id' => $item->enterprise_id
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $items = DB::table('addworking_enterprise_enterprises_has_users')
            ->whereNotNull('contract_id')
            ->get();

        foreach ($items as $item) {
            DB::table('contracts')->where('id', $item->contract_id)
                ->update([
                    'vendor_id'   => null,
                    'customer_id' => null
                ]);
        }
    }
}
