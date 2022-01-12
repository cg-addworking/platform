<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAddworkingContractContractTemplateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'addworking_contract_contract_template_variables',
            'addworking_contract_contract_model_variables'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename(
            'addworking_contract_contract_model_variables',
            'addworking_contract_contract_template_variables'
        );
    }
}
