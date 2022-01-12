<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSogetrelUserPassworkAcceptationHasContractTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_user_passwork_acceptation_has_contract_types', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->uuid('passwork_acceptation_id');
            $table->uuid('contract_type_id');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('passwork_acceptation_id')
                ->references('id')->on('sogetrel_user_passwork_acceptations')
                ->onDelete('CASCADE');

            $table->foreign('contract_type_id')
                ->references('id')->on('sogetrel_contract_types')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sogetrel_user_passwork_acceptation_has_contract_types');
    }
}
