<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseDocumentsAddDocumentModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->string('yousign_file_id')->nullable();
            $table->string('yousign_procedure_id')->nullable();
            $table->string('yousign_member_id')->nullable();
            $table->uuid('document_type_model_id')->nullable();
            $table->uuid('signed_by')->nullable();
            $table->dateTime('signed_at')->nullable();

            $table->foreign('document_type_model_id')
                ->references('id')
                ->on('addworking_enterprise_document_type_models')
                ->onDelete('set null');

            $table->foreign('signed_by')
                ->references('id')
                ->on('addworking_user_users')
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
            $table->dropColumn([
                'yousign_file_id',
                'yousign_procedure_id',
                'yousign_member_id',
                'document_type_model_id',
                'signed_by',
                'signed_at'
            ]);
        });
    }
}
