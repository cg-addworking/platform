<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->uuid('model_id')->nullable();
            $table->uuid('model_part_id')->nullable();
            $table->uuid('model_party_id')->nullable();
            $table->integer('number')->nullable();
            $table->string('display_name')->nullable();
            $table->string('input_type')->nullable();

            $table->text('description')->nullable()->change();
            $table->string('default_Value')->nullable()->change();
            $table->boolean('required')->nullable()->change();

            $table->foreign('model_id')
                ->references('id')->on('addworking_contract_contract_models')
                ->onDelete('cascade');
            $table->foreign('model_part_id')
                ->references('id')->on('addworking_contract_contract_model_parts')
                ->onDelete('cascade');
            $table->foreign('model_party_id')
                ->references('id')->on('addworking_contract_contract_model_parties')
                ->onDelete('cascade');
        });

        // workaround for sqlite to make the added column not null
        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->uuid('model_id')->nullable(false)->change();
            $table->uuid('model_part_id')->nullable(false)->change();
            $table->uuid('model_party_id')->nullable(false)->change();
            $table->integer('number')->nullable(false)->change();
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

        if($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
                $table->dropForeign(['model_id']);
                $table->dropForeign(['model_part_id']);
                $table->dropForeign(['model_party_id']);
            });
        }

        Schema::table('addworking_contract_contract_model_variables', function (Blueprint $table) {
            $table->dropColumn([
                'model_id',
                'model_part_id',
                'model_party_id',
                'number',
                'display_name',
                'input_type'
            ]);
        });
    }
}
