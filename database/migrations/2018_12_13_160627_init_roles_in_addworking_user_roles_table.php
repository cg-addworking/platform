<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class InitRolesInAddworkingUserRolesTable extends Migration
{
    protected $roles = [
        "activated",
        "admin",
        "customer",
        "vendor",
        "owner",
        "member",
        "employee",
        "cps1_signatory",
        "cps2_signatory",
        "cps3_signatory",
        "cps1_pending",
        "cps2_pending",
        "cps3_pending",
        "attestations_done",
        "factoring",
        "pending",
        "sogetrel_admin",
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->roles as $name) {
            $id = Str::uuid();
            DB::table('addworking_user_roles')->insert(@compact('id', 'name'));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->roles as $name) {
            DB::table('addworking_user_roles')->where(@compact('name'))->delete();
        }
    }
}
