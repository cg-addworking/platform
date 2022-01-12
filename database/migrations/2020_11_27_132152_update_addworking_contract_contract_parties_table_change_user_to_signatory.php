<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractPartiesTableChangeUserToSignatory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->uuid('signatory_id')->nullable();
            $table->string('signatory_name')->nullable();

            $table->foreign('signatory_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');
        });

        $contract_parties = DB::table('addworking_contract_contract_parties')->cursor();

        foreach ($contract_parties as $contract_party) {
            DB::table('addworking_contract_contract_parties')->where('id', $contract_party->id)
                ->update([
                    'signatory_id' => $contract_party->user_id,
                    'signatory_name' => $contract_party->signatory_name,
                ]);
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }

        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->dropColumn([
                'user_id',
                'user_name',
            ]);
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
            $table->uuid('user_id')->nullable();
            $table->string('user_name')->nullable();

            $table->foreign('user_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');
        });

        $contract_parties = DB::table('addworking_contract_contract_parties')->cursor();

        foreach ($contract_parties as $contract_party) {
            DB::table('addworking_contract_contract_parties')->where('id', $contract_party->id)
                ->update([
                    'user_id' => $contract_party->signatory_id,
                    'user_name' => $contract_party->user_name,
                ]);
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
                $table->dropForeign(['signatory_id']);
            });
        }

        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->dropColumn([
                'signatory_id',
                'signatory_name',
            ]);
        });
    }
}
