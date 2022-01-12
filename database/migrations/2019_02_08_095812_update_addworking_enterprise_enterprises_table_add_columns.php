<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingEnterpriseEnterprisesTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->boolean('is_customer')->default(false);
            $table->boolean('is_vendor')->default(false);

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
        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('is_customer');
        });

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('is_vendor');
        });

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
