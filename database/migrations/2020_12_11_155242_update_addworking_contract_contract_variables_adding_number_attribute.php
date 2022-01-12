<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractVariablesAddingNumberAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->integer('number')->nullable();
        });

        $contract_variables = DB::table('addworking_contract_contract_variables')
            ->orderBy('created_at', 'ASC')
            ->get();
        $number = 0;

        foreach ($contract_variables as $contract_variable) {
            $number++;
            DB::table('addworking_contract_contract_variables')
                ->where('id', $contract_variable->id)
                ->update(['number' => $number]);
        }

        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
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
        Schema::table('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
