<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelPartyDocumentTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_party_document_types', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            $table->uuid('document_model_id')->nullable();

            $table
                ->foreign('document_model_id')
                ->references('id')
                ->on('addworking_common_files')
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
        Schema::table('addworking_contract_contract_model_party_document_types', function (Blueprint $table) {
            $table->dropColumn(['name', 'display_name', 'description', 'document_model_id']);
        });
    }
}
