<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddworkingEnterpriseDocumentTypeSwornStatementModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_document_type_models', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('short_id');
            $table->uuid('document_type_id');
            $table->uuid('file_id');
            $table->string('name');
            $table->string('display_name');
            $table->integer('signature_page');
            $table->text('content');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('published_by')->nullable();
            $table->datetime('published_at')->nullable();

            $table->primary('id');

            $table->foreign('document_type_id')
                ->references('id')->on('addworking_enterprise_document_types')
                ->onDelete('set null');

            $table->foreign('file_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('set null');

            $table->foreign('published_by')
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
        Schema::dropIfExists('addworking_enterprise_document_type_models');
    }
}
