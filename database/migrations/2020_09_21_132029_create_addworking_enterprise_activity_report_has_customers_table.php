<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseActivityReportHasCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_activity_report_has_customers', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('activity_report_id');
            $table->uuid('customer_id');
            $table->timestamps();

            $table->primary(['id', 'activity_report_id', 'customer_id']);

            $table->foreign('activity_report_id')
                ->references('id')->on('addworking_enterprise_activity_reports')
                ->onDelete('cascade');

            $table->foreign('customer_id')
                ->references('id')->on('addworking_enterprise_enterprises')
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
        Schema::dropIfExists('addworking_enterprise_activity_report_has_customers');
    }
}
