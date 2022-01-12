<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingContractContractDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_contract_contract_documents', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_party_id');
            $table->uuid('document_id');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('contract_party_id')
                ->references('id')->on('addworking_contract_contract_parties')
                ->onDelete('cascade');

            $table->foreign('document_id')
                ->references('id')->on('addworking_enterprise_documents')
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
        Schema::dropIfExists('addworking_contract_contract_documents');
    }
}
