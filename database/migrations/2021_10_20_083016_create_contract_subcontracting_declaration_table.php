<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractSubcontractingDeclarationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_subcontracting_declaration', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_id');
            $table->datetime('validation_date');
            $table->string('percent_of_aggregation');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('contract_subcontracting_declaration');
    }
}
