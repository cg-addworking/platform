<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractsAddParentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->uuid('parent_id')->nullable();

            $table->foreign('parent_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');
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
            $table->dropColumn('parent_id');
        });
    }
}
