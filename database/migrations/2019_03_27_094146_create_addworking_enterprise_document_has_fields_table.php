<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingEnterpriseDocumentHasFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_document_has_fields', function (Blueprint $table) {
            $table->uuid('document_id');
            $table->uuid('field_id');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['document_id', 'field_id']);

            $table
                ->foreign('document_id')
                ->references('id')->on('addworking_enterprise_documents')
                ->onDelete('cascade');

            $table
                ->foreign('field_id')
                ->references('id')->on('addworking_enterprise_document_type_fields')
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
        Schema::dropIfExists('addworking_enterprise_document_has_fields');
    }
}
