<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnterpriseUserContractIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (in_array(config('database.default'), ['sqlite', 'sqlite_testing'])) {
            return;
        }

        Schema::table('enterprise_user', function (Blueprint $table) {
            $table->dropForeign(['contract_id']);
        });

        Schema::table('enterprise_user', function (Blueprint $table) {
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (in_array(config('database.default'), ['sqlite', 'sqlite_testing'])) {
            return;
        }

        Schema::table('enterprise_user', function (Blueprint $table) {

            $table->dropForeign('addworking_enterprise_enterprises_has_users_contract_id_foreign');
        });

        Schema::table('enterprise_user', function (Blueprint $table) {
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
        });
    }
}
