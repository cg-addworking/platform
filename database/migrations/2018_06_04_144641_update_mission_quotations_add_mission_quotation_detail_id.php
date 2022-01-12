<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMissionQuotationsAddMissionQuotationDetailId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->uuid('mission_quotation_detail_id')->nullable()->after('id');
            $table
                ->foreign('mission_quotation_detail_id')
                ->references('id')
                ->on('customer_charge_guru_mission_quotations_details')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('mission_quotations', 'mission_quotation_detail_id')) {
            Schema::table('mission_quotations', function (Blueprint $table) {
                $table->dropColumn('mission_quotation_detail_id');
            });
        }
    }
}
