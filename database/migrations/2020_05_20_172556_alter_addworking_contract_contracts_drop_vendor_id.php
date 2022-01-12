<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddworkingContractContractsDropVendorId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
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
            $table->uuid('vendor_id')->nullable();

            $table->foreign('vendor_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('set null');
        });
    }
}
