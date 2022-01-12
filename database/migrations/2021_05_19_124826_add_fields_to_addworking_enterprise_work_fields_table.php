<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAddworkingEnterpriseWorkFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->text('external_id')->nullable();
            $table->text('address')->nullable();
            $table->text('project_manager')->nullable();
            $table->text('project_owner')->nullable();
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
            $table->dropColumn('external_id');
        });
        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->dropColumn('address');
        });
        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->dropColumn('project_manager');
        });
        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->dropColumn('project_owner');
        });
    }
}
