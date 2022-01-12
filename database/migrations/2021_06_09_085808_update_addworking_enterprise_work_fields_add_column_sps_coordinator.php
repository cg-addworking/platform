<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseWorkFieldsAddColumnSpsCoordinator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->string('sps_coordinator')->nullable();
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
            $table->dropColumn('sps_coordinator');
        });
    }
}
