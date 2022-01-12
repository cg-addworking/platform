<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseDocumentsDropFileId extends Migration
{
    public function up(): void
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            if ($this->connection instanceof PostgresConnection) {
                $table->dropForeign(['file_id']);
            }
            $table->dropColumn('file_id');
        });
    }

    public function down(): void
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->uuid('file_id')->nullable();
            $table
                ->foreign('file_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('cascade');
        });
    }
}
