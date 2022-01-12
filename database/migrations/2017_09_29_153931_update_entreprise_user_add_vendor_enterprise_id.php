<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEntrepriseUserAddVendorEnterpriseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprise_user', function (Blueprint $table) {
            $table->uuid('vendor_enterprise_id')->nullable()->after('role_id');

            $table->foreign('vendor_enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprise_user', function (Blueprint $table) {
            $table->dropColumn('vendor_enterprise_id');
        });
    }
}
