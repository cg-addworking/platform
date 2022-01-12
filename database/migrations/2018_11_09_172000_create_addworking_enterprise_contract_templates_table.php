<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingEnterpriseContractTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('addworking_enterprise_contract_templates', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('customer_id');
            $table->uuid('file_id');
            $table->string('name');
            $table->boolean('is_framework')->default('false');
            $table->string('first_signatory_anchor');
            $table->string('second_signatory_anchor');
            $table->json('variables')->nullable();
            $table->primary('id');
            $table->timestamps();

            $table
                ->foreign('customer_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table
                ->foreign('file_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('addworking_enterprise_contract_templates');
    }
}
