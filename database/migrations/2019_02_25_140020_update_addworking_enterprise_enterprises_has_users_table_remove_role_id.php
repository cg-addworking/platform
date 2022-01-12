<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseEnterprisesHasUsersTableRemoveRoleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role_id = optional(DB::table('roles')
            ->select('id')->where('name', 'vendor')->first())->id;

        DB::table('addworking_enterprise_enterprises_has_users')
            ->where('role_id', $role_id)
            ->delete();

        DB::table('addworking_enterprise_enterprises_has_users')
            ->whereNotNull('role_id')
            ->update([
                'role_id' => null
            ]);

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('role_id');
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
            $table->uuid('role_id')->nullable();
            $table->foreign('role_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });
    }
}
