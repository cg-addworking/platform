<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->uuid('contract_id')->nullable();
            $table->uuid('contract_model_party_document_type_id')->nullable();

            $table
                ->foreign('contract_id')
                ->references('id')
                ->on('addworking_contract_contracts')
                ->onDelete('set null');

            $table
                ->foreign('contract_model_party_document_type_id')
                ->references('id')
                ->on('addworking_contract_contract_model_party_document_types')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->dropColumn(['contract_id', 'contract_model_party_document_type_id']);
        });
    }
}
