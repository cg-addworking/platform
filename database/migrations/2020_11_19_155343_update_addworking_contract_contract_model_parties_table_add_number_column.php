<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelPartiesTableAddNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_parties', function (Blueprint $table) {
            $table->integer('number')->nullable();
        });

        $contract_model_parties = DB::table('addworking_contract_contract_model_parties')->get();
        $number = 0;

        foreach ($contract_model_parties as $contract_model_party) {
            $number++;
            DB::table('addworking_contract_contract_model_parties')
                ->where('id', $contract_model_party->id)
                ->update(['number' => $number]);
        }

        // workaround for sqlite to make the added column not null
        Schema::table('addworking_contract_contract_model_parties', function (Blueprint $table) {
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
        Schema::table('addworking_contract_contract_model_parties', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
