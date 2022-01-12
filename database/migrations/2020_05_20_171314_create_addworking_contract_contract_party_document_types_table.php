<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingContractContractPartyDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_contract_contract_party_document_types', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_party_id');
            $table->uuid('document_type_id');
            $table->boolean('mandatory')->default(false);
            $table->boolean('validation_required')->default(false);
            $table->timestamps();
            $table->primary('id');

            $table->foreign('contract_party_id')
                ->references('id')->on('addworking_contract_contract_parties')
                ->onDelete('cascade');

            $table->foreign('document_type_id')
                ->references('id')->on('addworking_enterprise_document_types')
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
        Schema::dropIfExists('addworking_contract_contract_party_document_types');
    }
}
