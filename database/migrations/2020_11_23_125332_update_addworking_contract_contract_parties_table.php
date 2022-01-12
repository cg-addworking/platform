<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->uuid('contract_model_party_id')->nullable();
            $table->softDeletes();

            $table->foreign('contract_model_party_id')
                ->references('id')->on('addworking_contract_contract_model_parties')
                ->onDelete('cascade');
        });

        $contract_parties = DB::table('addworking_contract_contract_parties')->cursor();

        foreach ($contract_parties as $contract_party) {
            DB::table('addworking_contract_contract_parties')->where('id', $contract_party->id)
                ->update(['contract_model_party_id' => $contract_party->contract_template_party_id]);
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
                $table->dropForeign(['contract_template_party_id']);
            });
        }

        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->dropColumn(['contract_template_party_id']);
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
            $table->uuid('contract_template_party_id')->nullable();

            $table->foreign('contract_template_party_id')
                ->references('id')->on('addworking_contract_contract_model_parties')
                ->onDelete('cascade');
        });

        $contract_parties = DB::table('addworking_contract_contract_parties')->cursor();

        foreach ($contract_parties as $contract_party) {
            DB::table('addworking_contract_contract_parties')->where('id', $contract_party->id)
                ->update(['contract_template_party_id' => $contract_party->contract_model_party_id]);
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
                $table->dropForeign(['contract_model_party_id']);
            });
        }

        Schema::table('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->dropColumn([
                'contract_model_party_id',
                'deleted_at',
            ]);
        });
    }
}
