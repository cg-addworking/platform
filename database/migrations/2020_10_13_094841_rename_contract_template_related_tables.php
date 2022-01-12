<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameContractTemplateRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'addworking_contract_contract_templates',
            'addworking_contract_contract_models'
        );

        Schema::rename(
            'addworking_contract_contract_template_parts',
            'addworking_contract_contract_model_parts'
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
            'addworking_contract_contract_models',
            'addworking_contract_contract_templates'
        );

        Schema::rename(
            'addworking_contract_contract_model_parts',
            'addworking_contract_contract_template_parts'
        );
    }
}
