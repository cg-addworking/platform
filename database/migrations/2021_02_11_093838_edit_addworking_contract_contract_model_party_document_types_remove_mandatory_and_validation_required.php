<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAddworkingContractContractModelPartyDocumentTypesRemoveMandatoryAndValidationRequired extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_party_document_types', function (Blueprint $table) {
            $table->dropColumn('validation_required');
        });

        Schema::table('addworking_contract_contract_model_party_document_types', function (Blueprint $table) {
            $table->dropColumn('mandatory');
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
            $table->boolean('mandatory')->default(true);
            $table->boolean('validation_required')->default(true);
        });
    }
}