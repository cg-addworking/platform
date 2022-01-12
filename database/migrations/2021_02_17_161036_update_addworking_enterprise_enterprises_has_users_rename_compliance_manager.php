<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseEnterprisesHasUsersRenameComplianceManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->renameColumn('is_compliance_manager', 'is_customer_compliance_manager');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->renameColumn('is_customer_compliance_manager', 'is_compliance_manager');
        });
    }
}
