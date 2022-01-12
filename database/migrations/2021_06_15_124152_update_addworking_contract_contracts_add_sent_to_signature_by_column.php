<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractsAddSentToSignatureByColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->uuid('sent_to_signature_by')->nullable();

            $table->foreign('sent_to_signature_by')
                  ->references('id')
                  ->on('addworking_user_users')
                  ->onDelete('SET NULL');
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
                $table->dropForeign(['sent_to_signature_by']);
            });
        }

        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('sent_to_signature_by');
        });
    }
}
