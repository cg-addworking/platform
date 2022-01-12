<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractHasUsersTableAddSupportUpdatedSigningByColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_has_users', function (Blueprint $table) {
            $table->uuid('support_updated_signing_by')->nullable();

            $table
                ->foreign('support_updated_signing_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_has_users', function (Blueprint $table) {
            $table->dropColumn('support_updated_signing_by');
        });
    }
}
