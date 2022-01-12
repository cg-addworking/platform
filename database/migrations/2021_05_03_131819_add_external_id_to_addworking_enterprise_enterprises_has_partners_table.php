<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExternalIdToAddworkingEnterpriseEnterprisesHasPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises_has_partners', function (Blueprint $table) {
            $table->string('vendor_external_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_enterprises_has_partners', function (Blueprint $table) {
            $table->dropColumn('vendor_external_id');
        });
    }
}
