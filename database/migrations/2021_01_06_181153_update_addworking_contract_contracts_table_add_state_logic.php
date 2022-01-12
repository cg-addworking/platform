<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractsTableAddStateLogic extends Migration
{
    private $contractStateRepository;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->string('state')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->dateTime('inactive_at')->nullable();
        });

        $contracts = DB::table('addworking_contract_contracts')->cursor();
        foreach ($contracts as $contract) {
            switch($contract->status) {
                case 'signed':
                    DB::table('addworking_contract_contracts')->where('id', $contract->id)
                        ->update(['state' => 'signed']);
                    break;

                case 'draft':
                    DB::table('addworking_contract_contracts')->where('id', $contract->id)
                        ->update(['state' => 'draft']);
                    break;

                case 'ready_to_sign':
                    DB::table('addworking_contract_contracts')->where('id', $contract->id)
                    ->update(['state' => 'to_sign']);
                    break;

                case 'cancelled':
                    DB::table('addworking_contract_contracts')->where('id', $contract->id)
                    ->update(['state' => 'canceled']);
                    break;

                case 'active':
                    DB::table('addworking_contract_contracts')->where('id', $contract->id)
                    ->update(['state' => 'active']);
                    break;

                case 'inactive':
                    DB::table('addworking_contract_contracts')->where('id', $contract->id)
                        ->update(['state' => 'inactive']);
                    break;

                case 'expired':
                    DB::table('addworking_contract_contracts')->where('id', $contract->id)
                        ->update(['state' => 'due']);
                    break;

                case 'unknown':
                    DB::table('addworking_contract_contracts')->where('id', $contract->id)
                        ->update(['state' => 'unknown']);
                    break;
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn([
                'state',
                'canceled_at',
                'inactive_at'
            ]);
        });
    }
}
