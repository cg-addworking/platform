<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingContractContractTemplateAnnexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_contract_contract_template_annexes', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_template_id');
            $table->uuid('file_id');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('contract_template_id')
                ->references('id')->on('addworking_contract_contract_templates')
                ->onDelete('cascade');

            $table->foreign('file_id')
                ->references('id')->on('addworking_common_files')
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
        Schema::dropIfExists('addworking_contract_contract_template_annexes');
    }
}
