<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseEnterprisesHasUsersAddVendorComplianceManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->boolean('is_vendor_compliance_manager')->default(false);
        });

        $vendors = DB::table('addworking_enterprise_enterprises')
            ->where('is_vendor', true)
            ->orderBy('created_at', 'ASC')
            ->cursor();

        foreach ($vendors as $enterprise) {
            $users = DB::table('addworking_enterprise_enterprises_has_users')
            ->where('enterprise_id', $enterprise->id)
            ->cursor();
            foreach ($users as $user) {
                DB::table('addworking_enterprise_enterprises_has_users')
                ->where('user_id', $user->user_id)
                ->where('enterprise_id', $enterprise->id)
                ->update(['is_vendor_compliance_manager' => true]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('is_vendor_compliance_manager');
        });
    }
}
