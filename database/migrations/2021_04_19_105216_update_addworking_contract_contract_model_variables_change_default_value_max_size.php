<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelVariablesChangeDefaultValueMaxSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->string('default_value', 1500)->change();
        });
        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->string('value', 1500)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->string('default_value', 255)->change();
        });
        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->string('value', 255)->change();
        });
    }
}
