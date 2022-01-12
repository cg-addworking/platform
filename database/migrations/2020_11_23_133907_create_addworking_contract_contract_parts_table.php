<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingContractContractPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_contract_contract_parts', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_id');
            $table->uuid('contract_model_part_id')->nullable();
            $table->uuid('file_id')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->primary('id');

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');

            $table->foreign('contract_model_part_id')
                ->references('id')->on('addworking_contract_contract_model_parts')
                ->onDelete('cascade');

            $table->foreign('file_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_contract_contract_parts');
    }
}
