<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseWorkFieldAddColumnDeletedBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->uuid('deleted_by')->nullable();

            $table->foreign('deleted_by')
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
        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });
    }
}
