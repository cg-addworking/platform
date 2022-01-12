<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelPartiesAddContractModelIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_parties', function (Blueprint $table) {
            $table->uuid('contract_model_id')->nullable();

            $table->foreign('contract_model_id')
                ->references('id')->on('addworking_contract_contract_models')
                ->onDelete('cascade');
        });

        // workaround for sqlite to make the added column not null
        Schema::table('addworking_contract_contract_model_parties', function (Blueprint $table) {
            $table->uuid('contract_model_id')->nullable(false)->change();
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

        if($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_model_parties', function (Blueprint $table) {
                $table->dropForeign(['contract_model_id']);
            });
        }

        Schema::table('addworking_contract_contract_model_parties', function (Blueprint $table) {
            $table->dropColumn(['contract_model_id']);
        });
    }
}
