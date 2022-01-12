<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractsAddNextPartyToSignIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->uuid('next_party_to_sign_id')->nullable();
            $table->uuid('next_party_to_validate_id')->nullable();

            $table
                ->foreign('next_party_to_sign_id')
                ->references('id')
                ->on('addworking_contract_contract_parties')
                ->onDelete('set null');
            $table
                ->foreign('next_party_to_validate_id')
                ->references('id')
                ->on('addworking_contract_contract_parties')
                ->onDelete('set null');
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
            Schema::table('addworking_contract_contracts', function (Blueprint $table) {
                $table->dropForeign(['next_party_to_sign_id']);
            });
            Schema::table('addworking_contract_contracts', function (Blueprint $table) {
                $table->dropForeign(['next_party_to_validate_id']);
            });
        }
    }
}
