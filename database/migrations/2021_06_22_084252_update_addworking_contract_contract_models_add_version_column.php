<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractModelsAddVersionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_models', function (Blueprint $table) {
            $table->integer('version_number')->default(1);
            $table->uuid('versionning_from_id')->nullable();

            $table->foreign('versionning_from_id')
                  ->references('id')
                  ->on('addworking_contract_contract_models')
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
        Schema::table('addworking_contract_contract_models', function (Blueprint $table) {
            $table->dropColumn(['version_number', 'versionning_from_id']);
        });
    }
}
