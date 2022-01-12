<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingEnterpriseDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_documents', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('type_id')->nullable();
            $table->uuid('enterprise_id');
            $table->uuid('file_id');
            $table->date('valid_from');
            $table->date('valid_until')->nullable();
            $table->string('status')->nullable();
            $table->string('reason_for_rejection')->nullable();
            $table->date('accepted_at')->nullable();
            $table->date('rejected_at')->nullable();
            $table->uuid('accepted_by')->nullable();
            $table->uuid('rejected_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('type_id')
                ->references('id')->on('addworking_enterprise_document_types')
                ->onDelete('set null');

            $table
                ->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table
                ->foreign('file_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('cascade');

            $table
                ->foreign('accepted_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');

            $table
                ->foreign('rejected_by')
                ->references('id')->on('addworking_user_users')
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
        Schema::dropIfExists('addworking_enterprise_documents');
    }
}
