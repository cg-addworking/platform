<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingContractContractTemplatePartyDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_contract_contract_template_party_document_types', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_template_party_id');
            $table->uuid('document_type_id');
            $table->boolean('mandatory')->default(false);
            $table->boolean('validation_required')->default(false);
            $table->uuid('validated_by')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('contract_template_party_id')
                ->references('id')->on('addworking_contract_contract_template_parties')
                ->onDelete('cascade');

            $table->foreign('document_type_id')
                ->references('id')->on('addworking_enterprise_document_types')
                ->onDelete('cascade');

            $table->foreign('validated_by')
                ->references('id')->on('addworking_contract_contract_template_parties')
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
        Schema::dropIfExists('addworking_contract_contract_template_party_document_types');
    }
}
