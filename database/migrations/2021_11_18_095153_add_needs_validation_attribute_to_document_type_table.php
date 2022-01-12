<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNeedsValidationAttributeToDocumentTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_document_types', function (Blueprint $table) {
            $table->boolean('needs_customer_validation')->default(false);
            $table->boolean('needs_support_validation')->default(true);

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
            $table->dropColumn([
                'needs_customer_validation',
                'needs_support_validation',
            ]);
        });
    }
}
