<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->uuid('contract_model_variable_id')->nullable();
            $table->uuid('filled_by')->nullable();

            $table->foreign('contract_model_variable_id')
                ->references('id')->on('addworking_contract_contract_model_variables')
                ->onDelete('cascade');

            $table->foreign('filled_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');
        });

        $contract_variables = DB::table('addworking_contract_contract_variables')->cursor();

        foreach ($contract_variables as $contract_variable) {
            DB::table('addworking_contract_contract_variables')->where('id', $contract_variable->id)
                ->update(['contract_model_variable_id' => $contract_variable->contract_template_variable_id]);
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
                $table->dropForeign(['contract_template_variable_id']);
            });
        }

        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->dropColumn(['contract_template_variable_id']);
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
            $table->uuid('contract_template_variable_id')->nullable();

            $table->foreign('contract_template_variable_id')
                ->references('id')->on('addworking_contract_contract_model_variables')
                ->onDelete('cascade');
        });

        $contract_variables = DB::table('addworking_contract_contract_variables')->cursor();

        foreach ($contract_variables as $contract_variable) {
            DB::table('addworking_contract_contract_variables')->where('id', $contract_variable->id)
                ->update(['contract_template_variable_id' => $contract_variable->contract_model_variable_id]);
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
                $table->dropForeign(['contract_model_variable_id']);
                $table->dropForeign(['filled_by']);
            });
        }

        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->dropColumn([
                'contract_model_variable_id',
                'filled_by',
            ]);
        });
    }
}
