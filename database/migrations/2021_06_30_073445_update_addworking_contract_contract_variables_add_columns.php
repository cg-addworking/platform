<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractVariablesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->integer('order')->default(0);
            $table->uuid('model_part_id')->nullable();

            $table->foreign('model_part_id')
                  ->references('id')
                  ->on('addworking_contract_contract_model_parts')
                  ->onDelete('SET NULL');
        });

        $variables = DB::table('addworking_contract_variable_has_model_parts')->cursor();

        foreach ($variables as $variable) {
            DB::table('addworking_contract_contract_model_variables')->where('id', $variable->model_variable_id)
                ->update(['order' => $variable->order, 'model_part_id' => $variable->model_part_id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->dropColumn(['order', 'model_part_id']);
        });
    }
}
