<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelPartyDocumentTypesTableDropColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $party_document_types = DB::table('addworking_contract_contract_model_party_document_types')->cursor();

        foreach ($party_document_types as $document_type) {
            DB::table('addworking_contract_contract_model_party_document_types')->where('id', $document_type->id)
                ->update(['contract_model_party_id' => $document_type->contract_template_party_id]);
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_model_party_document_types', function (Blueprint $table) {
                $table->dropForeign(['contract_template_party_id']);
            });
        }

        Schema::table('addworking_contract_contract_model_party_document_types', function (Blueprint $table) {
            $table->dropColumn(['contract_template_party_id']);
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
            $table->uuid('contract_template_party_id')->nullable();

            $table->foreign('contract_template_party_id')
                ->references('id')->on('addworking_contract_contract_model_parties')
                ->onDelete('cascade');
        });

        $party_document_types = DB::table('addworking_contract_contract_model_party_document_types')->cursor();

        foreach ($party_document_types as $document_type) {
            DB::table('addworking_contract_contract_model_party_document_types')->where('id', $document_type->id)
                ->update(['contract_template_party_id' => $document_type->contract_model_party_id]);
        }
    }
}
