<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContractsTablesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->string('yousign_procedure_id')->nullable();
        });

        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->string('yousign_member_id')->nullable();
            $table->string('yousign_file_object_id')->nullable();
        });

        Schema::table('addworking_contract_contract_parts', function (Blueprint $table) {
            $table->string('yousign_file_id')->nullable();
        });

        Schema::table('addworking_contract_contract_model_parts', function (Blueprint $table) {
            $table->integer('signature_page')->nullable();
            $table->string('signature_mention')->nullable();
        });

        Schema::table('addworking_contract_contract_model_parties', function (Blueprint $table) {
            $table->string('signature_position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('yousign_procedure_id');
        });

        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->dropColumn('yousign_member_id');
        });

        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->dropColumn('yousign_file_object_id');
        });

        Schema::table('addworking_contract_contract_parts', function (Blueprint $table) {
            $table->dropColumn('yousign_file_id');
        });

        Schema::table('addworking_contract_contract_model_parts', function (Blueprint $table) {
            $table->dropColumn('signature_page');
        });

        Schema::table('addworking_contract_contract_model_parts', function (Blueprint $table) {
            $table->dropColumn('signature_mention');
        });

        Schema::table('addworking_contract_contract_model_parties', function (Blueprint $table) {
            $table->dropColumn('signature_position');
        });
    }
}
