<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddworkingEnterpriseDocumentRejectReasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_document_reject_reasons', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->string('name');
            $table->string('display_name');
            $table->longText('message');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');

            $table->uuid('document_type_id')->nullable();
            $table->foreign('document_type_id')
                ->references('id')
                ->on('addworking_enterprise_document_types')
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
        Schema::dropIfExists('addworking_enterprise_document_reject_reasons');
    }
}
