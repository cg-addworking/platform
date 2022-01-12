<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropQuotationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::dropIfExists('customer_charge_guru_mission_quotations');
        Schema::dropIfExists('addworking_mission_quotation_lines');
        Schema::dropIfExists('addworking_mission_proposals_has_quotations');
        Schema::dropIfExists('addworking_mission_quotations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
