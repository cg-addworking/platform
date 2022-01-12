<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingEnterpriseEnterprisesHasUsersTableAddColumnsForPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_operator')->default(false);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('access_to_billing')->default(true);
            $table->boolean('access_to_mission')->default(true);
            $table->boolean('access_to_contract')->default(true);
            $table->boolean('access_to_user')->default(true);
            $table->boolean('access_to_enterprise')->default(true);
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
            $table->dropColumn('is_admin');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('is_operator');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('is_readonly');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('access_to_billing');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('access_to_mission');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('access_to_contract');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('access_to_user');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('access_to_enterprise');
        });
    }
}
