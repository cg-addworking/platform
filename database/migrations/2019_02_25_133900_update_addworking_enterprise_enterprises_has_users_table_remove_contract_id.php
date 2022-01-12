<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingEnterpriseEnterprisesHasUsersTableRemoveContractId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('addworking_enterprise_enterprises_has_users')
            ->whereNotNull('contract_id')
            ->update([
                'contract_id' => null
            ]);

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('contract_id');
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
            $table->uuid('contract_id')->nullable();
            $table->foreign('contract_id')
                ->references('id')->on('contracts')
                ->onDelete('cascade');
        });
    }
}
