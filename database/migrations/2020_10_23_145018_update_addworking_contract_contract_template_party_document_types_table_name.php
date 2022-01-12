<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractTemplatePartyDocumentTypesTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'addworking_contract_contract_template_party_document_types',
            'addworking_contract_contract_model_party_document_types'
        );

        Schema::table('addworking_contract_contract_model_party_document_types', function (Blueprint $table) {
            $table->uuid('contract_model_party_id')->nullable();

            $table->foreign('contract_model_party_id')
                ->references('id')->on('addworking_contract_contract_model_parties')
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
        Schema::table('addworking_contract_contract_model_party_document_types', function (Blueprint $table) {
            $table->dropColumn(['contract_model_party_id']);
        });

        Schema::rename(
            'addworking_contract_contract_model_party_document_types',
            'addworking_contract_contract_template_party_document_types'
        );
    }
}
