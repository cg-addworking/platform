<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingEnterpriseEnterprisesHasUsersTableAddNewData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $owner_role_id = optional(DB::table('roles')
            ->select('id')->where('name', 'owner')->first())->id;

        $enterprises = DB::table('addworking_enterprise_enterprises')
            ->select('id', 'signatory_id')->get();

        foreach ($enterprises as $enterprise) {
            if (is_null($enterprise->signatory_id)) {
                continue;
            }

            DB::table('addworking_enterprise_enterprises_has_users')
                ->where('enterprise_id', $enterprise->id)
                ->where('user_id', $enterprise->signatory_id)
                ->update(['is_signatory' => true]);
        }

        $owners = DB::table('addworking_enterprise_enterprises_has_users')
            ->select('user_id', 'enterprise_id')
            ->where('role_id', $owner_role_id)
            ->get();

        foreach ($owners as $owner) {
            DB::table('addworking_enterprise_enterprises_has_users')
                ->where('enterprise_id', $owner->enterprise_id)
                ->where('user_id', $owner->user_id)
                ->update(['is_legal_representative' => true]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('addworking_enterprise_enterprises_has_users')
            ->update(['is_signatory' => false]);

        DB::table('addworking_enterprise_enterprises_has_users')
            ->update(['is_legal_representative' => false]);
    }
}
