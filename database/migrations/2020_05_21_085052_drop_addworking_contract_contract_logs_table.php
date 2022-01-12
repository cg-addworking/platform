<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAddworkingContractContractLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("addworking_contract_contract_logs");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('addworking_contract_contract_logs', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_id');
            $table->text('message');
            $table->json('data');
            $table->timestamps();

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');
        });
    }
}
