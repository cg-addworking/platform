<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingDocumentHasFilesAddPrimary extends Migration
{
    public function up()
    {
        Schema::table('addworking_enterprise_document_has_files', function (Blueprint $table) {
            $table->primary(['document_id', 'file_id']);
        });
    }

    public function down()
    {
        Schema::table('addworking_enterprise_document_has_files', function (Blueprint $table) {
            $table->dropPrimary(['document_id', 'file_id']);
        });
    }
}
