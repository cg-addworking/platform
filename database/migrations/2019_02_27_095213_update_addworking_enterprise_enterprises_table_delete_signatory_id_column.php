<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingEnterpriseEnterprisesTableDeleteSignatoryIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('addworking_enterprise_enterprises')
            ->whereNotNull('signatory_id')
            ->update([
                'signatory_id' => null
            ]);

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('signatory_id');
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
            $table->uuid('signatory_id')->nullable();
        });
    }
}
