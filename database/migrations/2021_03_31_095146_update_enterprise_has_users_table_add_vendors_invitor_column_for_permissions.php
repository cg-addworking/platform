<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateEnterpriseHasUsersTableAddVendorsInvitorColumnForPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->boolean('is_allowed_to_invite_vendors')->default(false);
        });

        $users = DB::table('addworking_enterprise_enterprises_has_users')->get();
        
        foreach ($users as $user) {
            if ($user->is_admin) {
                DB::table('addworking_enterprise_enterprises_has_users')
                ->where('user_id', $user->user_id)
                ->update(['is_allowed_to_invite_vendors' => true]);            
            } 
        }
        
        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->boolean('is_allowed_to_invite_vendors')->nullable(false)->change();
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
            $table->dropColumn('is_allowed_to_invite_vendors');
        });
    }
}
