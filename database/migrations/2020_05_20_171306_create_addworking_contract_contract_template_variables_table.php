<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingContractContractTemplateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_contract_contract_template_variables', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_template_id');
            $table->string('name');
            $table->text('description');
            $table->string('default_Value');
            $table->boolean('required');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('contract_template_id')
                ->references('id')->on('addworking_contract_contract_templates')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_contract_contract_template_variables');
    }
}
