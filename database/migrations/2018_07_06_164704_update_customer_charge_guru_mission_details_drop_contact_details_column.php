<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerChargeGuruMissionDetailsDropContactDetailsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('contact_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->json('contact_details')->nullable();
        });
    }
}
