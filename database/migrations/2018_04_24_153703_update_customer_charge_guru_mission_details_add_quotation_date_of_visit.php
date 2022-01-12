<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerChargeGuruMissionDetailsAddQuotationDateOfVisit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->datetime('quotation_date_of_visit')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('customer_charge_guru_mission_details', 'quotation_date_of_visit')) {
            Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
                $table->dropColumn('quotation_date_of_visit');
            });
        }
    }
}
