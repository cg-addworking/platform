<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSogetrelUserPassworksHasContractTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_user_passworks_has_contract_types', function (Blueprint $table) {
            $table->uuid('type_id');
            $table->uuid('passwork_id');
            $table->primary(['type_id', 'passwork_id']);
            $table
                ->foreign('type_id')
                ->references('id')->on('sogetrel_contract_types')
                ->onDelete('cascade');

            $table
                ->foreign('passwork_id')
                ->references('id')->on('sogetrel_user_passworks')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sogetrel_user_passworks_has_contract_types');
    }
}
