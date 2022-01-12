<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractTemplateVariablesTableDropContractTemplateIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_template_variables', function (Blueprint $table) {
                $table->dropForeign(['contract_template_id']);
            });
        }

        Schema::table('addworking_contract_contract_template_variables', function (Blueprint $table) {
            $table->dropColumn(['contract_template_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contract_template_variables', function (Blueprint $table) {
            $table->uuid('contract_template_id')->nullable();

            $table->foreign('contract_template_id')
                ->references('id')->on('addworking_contract_contract_models')
                ->onDelete('cascade');
        });

        // workaround for sqlite to make the added column not null
        Schema::table('addworking_contract_contract_template_variables', function (Blueprint $table) {
            $table->uuid('contract_template_id')->nullable(false)->change();
        });
    }
}
