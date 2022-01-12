<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableAddworkingContractVariableHasModelParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('addworking_contract_variable_has_model_parts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('addworking_contract_variable_has_model_parts', function (Blueprint $table) {
            $table->integer('order')->default(0);
            $table->uuid('model_part_id');
            $table->uuid('model_variable_id');

            $table->foreign('model_part_id')
                  ->references('id')
                  ->on('addworking_contract_contract_model_parts')
                  ->onDelete('SET NULL');

            $table->foreign('model_variable_id')
                  ->references('id')
                  ->on('addworking_contract_contract_model_variables')
                  ->onDelete('SET NULL');
        });
    }
}
