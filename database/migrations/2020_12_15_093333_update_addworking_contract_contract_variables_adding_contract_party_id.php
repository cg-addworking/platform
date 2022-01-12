<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractVariablesAddingContractPartyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->uuid('contract_party_id')->nullable();
            $table->foreign('contract_party_id')
                ->references('id')->on('addworking_contract_contract_parties');
        });
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
            Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
                $table->dropForeign(['contract_party_id']);
            });
        }

        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->dropColumn('contract_party_id');
        });
    }
}
