<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingEnterpriseDocumentTypeFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_document_type_fields', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('type_id')->nullable();
            $table->string('name');
            $table->string('display_name');
            $table->text('help_text')->nullable();
            $table->boolean('is_mandatory')->default(false);
            $table->string('input_type')->default('text');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('type_id')
                ->references('id')->on('addworking_enterprise_document_types')
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
        Schema::dropIfExists('addworking_enterprise_document_type_fields');
    }
}
