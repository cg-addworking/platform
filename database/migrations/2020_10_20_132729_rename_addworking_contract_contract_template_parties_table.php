<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAddworkingContractContractTemplatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'addworking_contract_contract_template_parties',
            'addworking_contract_contract_model_parties'
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
            'addworking_contract_contract_model_parties',
            'addworking_contract_contract_template_parties'
        );
    }
}
