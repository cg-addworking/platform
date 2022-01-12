<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseDocumentTypesAddNeedAnAuthenticityCheckColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_document_types', function (Blueprint $table) {
            $table->boolean('need_an_authenticity_check')->default('false');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_document_types', function (Blueprint $table) {
            $table->dropColumn('need_an_authenticity_check');
        });
    }
}
