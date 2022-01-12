<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddworkingContractContractsAddEnterpriseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->uuid('enterprise_id')->nullable();

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('set null');
        });

        DB::table('addworking_contract_contracts')->get(['id', 'customer_id', 'vendor_id'])->each(function ($row) {
            DB::table('addworking_contract_contracts')
                ->where('id', $row->id)
                ->update(['enterprise_id' => $row->customer_id ?? $row->vendor_id]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('enterprise_id');
        });
    }
}
