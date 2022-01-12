<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractPartiesAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->string('signature_position')->nullable();
        });

        $parties = DB::table('addworking_contract_contract_parties')
            ->whereNotNull('contract_model_party_id')
            ->orderBy('created_at', 'ASC')
            ->cursor();

        foreach ($parties as $party) {
            $model =  DB::table('addworking_contract_contract_model_parties')
                ->where('id', $party->contract_model_party_id)
                ->first();

            DB::table('addworking_contract_contract_parties')
                ->update([
                    'signature_position' => $model->signature_position,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->dropColumn('signature_position');
        });
    }
}
