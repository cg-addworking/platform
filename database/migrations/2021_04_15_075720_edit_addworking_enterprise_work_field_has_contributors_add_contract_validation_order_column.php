<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAddworkingEnterpriseWorkFieldHasContributorsAddContractValidationOrderColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_work_field_has_contributors', function (Blueprint $table) {
            $table->integer('contract_validation_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_work_field_has_contributors', function (Blueprint $table) {
            $table->dropColumn('contract_validation_order');
        });
    }
}
