<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelPartsTableAddNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_parts', function (Blueprint $table) {
            $table->integer('number')->nullable();
        });

        $contract_model_parts = DB::table('addworking_contract_contract_model_parts')
            ->orderBy('created_at', 'ASC')
            ->get();
        $number = 0;

        foreach ($contract_model_parts as $contract_model_part) {
            $number++;
            DB::table('addworking_contract_contract_model_parts')
                ->where('id', $contract_model_part->id)
                ->update(['number' => $number]);
        }

        // workaround for sqlite to make the added column not null
        Schema::table('addworking_contract_contract_model_parts', function (Blueprint $table) {
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
        Schema::table('addworking_contract_contract_model_parts', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
