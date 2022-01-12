<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAddworkingEnterpriseWorkFieldHasContributorsAddIsContractValidatorColum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_work_field_has_contributors', function (Blueprint $table) {
            $table->boolean('is_contract_validator')->default(false);
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
            $table->dropColumn('is_contract_validator');
        });
    }
}
