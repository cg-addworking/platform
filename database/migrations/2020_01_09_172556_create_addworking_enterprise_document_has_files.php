<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseDocumentHasFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_document_has_files', function (Blueprint $table) {
            $table->uuid('document_id');
            $table->uuid('file_id');
            $table->timestamps();

            $table->foreign('document_id')
                ->references('id')->on('addworking_enterprise_documents')
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
        Schema::dropIfExists('addworking_enterprise_document_has_files');
    }
}
