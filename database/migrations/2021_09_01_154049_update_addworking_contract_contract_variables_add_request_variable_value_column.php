<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractVariablesAddRequestVariableValueColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->uuid('value_requested_to')->nullable();
            $table->dateTime('value_requested_at')->nullable();

            $table->foreign('value_requested_to')
                ->references('id')->on('addworking_user_users')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->dropColumn('value_requested_to');
        });

        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->dropColumn('value_requested_at');
        });
    }
}
