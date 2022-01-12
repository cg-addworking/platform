<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->uuid('contract_model_id')->nullable();
            $table->datetime('archived_at')->nullable();
            $table->uuid('archived_by')->nullable();

            $table->foreign('contract_model_id')
                ->references('id')->on('addworking_contract_contract_models')
                ->onDelete('cascade');

            $table->foreign('archived_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');
        });

        $contracts = DB::table('addworking_contract_contracts')->cursor();

        foreach ($contracts as $contract) {
            DB::table('addworking_contract_contracts')->where('id', $contract->id)
                ->update(['contract_model_id' => $contract->contract_template_id]);
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contracts', function (Blueprint $table) {
                $table->dropForeign(['contract_template_id']);
            });
        }

        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn(['contract_template_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->uuid('contract_template_id')->nullable();

            $table->foreign('contract_template_id')
                ->references('id')->on('addworking_contract_contract_models')
                ->onDelete('cascade');
        });

        $contracts = DB::table('addworking_contract_contracts')->cursor();

        foreach ($contracts as $contract) {
            DB::table('addworking_contract_contracts')->where('id', $contract->id)
                ->update(['contract_template_id' => $contract->contract_model_id]);
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contracts', function (Blueprint $table) {
                $table->dropForeign(['contract_model_id']);
                $table->dropForeign(['archived_by']);
            });
        }

        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn([
                'contract_model_id',
                'archived_at',
                'archived_by',
            ]);
        });
    }
}
