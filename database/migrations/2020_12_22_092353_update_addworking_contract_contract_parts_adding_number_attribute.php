<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractPartsAddingNumberAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_parts', function (Blueprint $table) {
            $table->integer('number')->nullable();
        });

        $contract_parts = DB::table('addworking_contract_contract_parts')
            ->orderBy('created_at', 'ASC')
            ->get();
        $number = 0;

        foreach ($contract_parts as $contract_part) {
            $number++;
            DB::table('addworking_contract_contract_parts')
                ->where('id', $contract_part->id)
                ->update(['number' => $number]);
        }

        Schema::table('addworking_contract_contract_parts', function (Blueprint $table) {
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
        Schema::table('addworking_contract_contract_parts', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
