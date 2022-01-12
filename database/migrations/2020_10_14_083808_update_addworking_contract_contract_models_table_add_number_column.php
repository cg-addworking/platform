<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelsTableAddNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_models', function (Blueprint $table) {
            $table->integer('number')->nullable();
        });

        $contract_models = DB::table('addworking_contract_contract_models')->get();
        $number = 0;

        foreach ($contract_models as $contract_model) {
            $number++;
            DB::table('addworking_contract_contract_models')
                ->where('id', $contract_model->id)
                ->update(['number' => $number]);
        }

        // workaround for sqlite to make the added column not null
        Schema::table('addworking_contract_contract_models', function (Blueprint $table) {
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
        Schema::table('addworking_contract_contract_models', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
