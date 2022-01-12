<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAddworkingContractContractsAddWorkfieldIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->uuid('workfield_id')->nullable();

            $table
                ->foreign('workfield_id')
                ->references('id')
                ->on('addworking_enterprise_work_fields')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_contract_contracts', function (Blueprint $table) {
                $table->dropForeign(['workfield_id']);
            });
        }

        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('workfield_id');
        });
    }
}
