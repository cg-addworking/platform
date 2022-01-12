<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddworkingEnterpriseDocumentTypeSwornStatementVariables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_document_type_model_variables', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('short_id');
            $table->uuid('document_type_model_id');
            $table->string('name');
            $table->string('display_name');
            $table->string('input_type');
            $table->string('default_value')->nullable();
            $table->string('description')->nullable();
            $table->json('options')->nullable();
            $table->boolean('required')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('document_type_model_id')
                ->references('id')->on('addworking_enterprise_document_type_models')
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
        Schema::dropIfExists('addworking_enterprise_document_type_model_variables');
    }
}
