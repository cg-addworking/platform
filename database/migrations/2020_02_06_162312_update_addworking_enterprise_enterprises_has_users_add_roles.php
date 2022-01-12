<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseEnterprisesHasUsersAddRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->boolean('is_mission_offer_broadcaster')->default(true);
            $table->boolean('is_mission_offer_closer')->default(true);
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
            $table->dropColumn('is_mission_offer_broadcaster');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('is_mission_offer_closer');
        });
    }
}
