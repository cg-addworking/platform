<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelVariablesTableRenameDefaultValueColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->renameColumn("`default_Value`", "`default_value`");
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
            $table->renameColumn("`default_value`", "`default_Value`");
        });
    }
}
