<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAddworkingEnterpriseHasContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // attempt to associate potentially orphan contracts to their
        // legitimate owner (the customer.)
        DB::table('addworking_enterprise_has_contracts')->get()->each(function ($row) {
            $enterprise = DB::table('addworking_enterprise_enterprises')
                ->where('id', $row->enterprise_id)
                ->first();

            $contract = DB::table('addworking_contract_contracts')
                ->where('id', $row->contract_id)
                ->first();

            if ($enterprise->is_customer && is_null($contract->enterprise_id)) {
                DB::table('addworking_contract_contracts')
                    ->where('id', $contract->id)
                    ->update(['enterprise_id' => $enterprise->id]);
            }
        });

        Schema::dropIfExists('addworking_enterprise_has_contracts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('addworking_enterprise_has_contracts', function (Blueprint $table) {
            $table->uuid('contract_id');
            $table->uuid('enterprise_id');

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });
    }
}
