<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseDocumentsAddRequiredDocumentIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->uuid('required_document_id')->nullable();

            $table->foreign('required_document_id')
                ->references('id')
                ->on('addworking_common_files')
                ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->dropColumn('required_document_id');
        });
    }
}
