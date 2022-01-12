<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractYousignPayloadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_yousign_payloads', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_id');
            $table->json('payload');
            $table->string('action');
            $table->timestamps();

            $table->primary('id');

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
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
        Schema::dropIfExists('contract_yousign_payloads');
    }
}
