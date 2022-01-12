<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractPartiesTableAddNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->integer('number')->nullable();
        });

        $contract_parties = DB::table('addworking_contract_contract_parties')->get();
        $number = 0;

        foreach ($contract_parties as $contract_party) {
            $number++;
            DB::table('addworking_contract_contract_parties')
                ->where('id', $contract_party->id)
                ->update(['number' => $number]);
        }

        // workaround for sqlite to make the added column not null
        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
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
        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
