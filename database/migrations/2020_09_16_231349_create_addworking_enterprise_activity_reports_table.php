<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseActivityReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_activity_reports', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('vendor_id');
            $table->uuid('created_by');
            $table->string('month');
            $table->string('year');
            $table->string('other_activity')->nullable();
            $table->boolean('no_activity')->default(false);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->unique(['vendor_id','month','year'], 'activity_report_month_unique');

            $table->foreign('vendor_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->references('id')->on('addworking_user_users')
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
        Schema::dropIfExists('addworking_enterprise_activity_reports');
    }
}
