<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingEnterpriseEnterprisesHasUsersTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->boolean('is_signatory')->default(false);
            $table->boolean('is_legal_representative')->default(false);

            $table->softDeletes();
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
            $table->dropColumn('is_signatory');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('is_legal_representative');
        });

        Schema::table('addworking_enterprise_enterprises_has_users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
