<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersGrantPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('addworking_user_users')
            ->where('email', 'like', '%@addworking.com')
            ->update([
                "is_system_superadmin" => false,
                "is_system_admin"      => true,
                "is_system_operator"   => false,
            ]);

        DB::table('addworking_user_users')
            ->whereIn('email', ['benjamin@addworking.com', 'charles@addworking.com'])
            ->update([
                "is_system_superadmin" => true,
                "is_system_admin"      => false,
                "is_system_operator"   => false,
            ]);

        DB::table('addworking_enterprise_enterprises_has_users')
            ->update([
                'is_admin'             => true,
                'access_to_billing'    => true,
                'access_to_mission'    => true,
                'access_to_contract'   => true,
                'access_to_user'       => true,
                'access_to_enterprise' => true,
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('addworking_enterprise_enterprises_has_users')
            ->update([
                'is_admin'             => false,
                'is_operator'          => false,
                'is_readonly'          => false,
                'access_to_billing'    => false,
                'access_to_mission'    => false,
                'access_to_contract'   => false,
                'access_to_user'       => false,
                'access_to_enterprise' => false,
            ]);

        DB::table('addworking_user_users')
            ->update([
                'is_system_superadmin' => false,
                'is_system_admin'      => false,
                'is_system_operator'   => false,
            ]);
    }
}
