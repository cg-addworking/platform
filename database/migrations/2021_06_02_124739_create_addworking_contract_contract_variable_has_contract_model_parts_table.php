<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingContractContractVariableHasContractModelPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $contract_model_variables = DB::table('addworking_contract_contract_model_variables')->get();
        $contract_model_variable_data = [];

        foreach ($contract_model_variables as $contract_model_variable) {
            $contract_model_variable_data[] = [
                'contract_model_variable_id' => $contract_model_variable->id,
                'contract_model_part_id' => $contract_model_variable->model_part_id,
                'order' => $contract_model_variable->order,
            ];
        }

        Schema::create('addworking_contract_variable_has_model_parts', function (Blueprint $table) {
            $table->uuid('model_part_id');
            $table->uuid('model_variable_id');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->primary(['model_variable_id', 'model_part_id']);

            $table
                ->foreign('model_variable_id')
                ->references('id')
                ->on('addworking_contract_contract_model_variables')
                ->onDelete('cascade');

            $table
                ->foreign('model_part_id')
                ->references('id')
                ->on('addworking_contract_contract_model_parts')
                ->onDelete('cascade');
        });

        foreach ($contract_model_variable_data as $contract_model_variable_datum) {
            DB::table('addworking_contract_variable_has_model_parts')->insert(
                [
                    'model_part_id' => $contract_model_variable_datum['contract_model_part_id'],
                    'model_variable_id' => $contract_model_variable_datum['contract_model_variable_id'],
                    'order' => $contract_model_variable_datum['order'],
                ]
            );
        }

        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->dropColumn('model_part_id');
        });
        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_variable_has_model_parts', function (Blueprint $table) {
                $table->dropForeign(['model_variable_id']);
            });
            Schema::table('addworking_contract_variable_has_model_parts', function (Blueprint $table) {
                $table->dropForeign(['model_part_id']);
            });
        }
        Schema::dropIfExists('addworking_contract_variable_has_model_parts');

        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->uuid('model_part_id')->nullable();
            $table->foreign('model_part_id')
                ->references('id')
                ->on('addworking_contract_contract_model_parts')
                ->onDelete('cascade');

            $table->integer('order')->default(0);
        });

        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->uuid('model_part_id')->nullable(false)->change();
        });
    }
}
