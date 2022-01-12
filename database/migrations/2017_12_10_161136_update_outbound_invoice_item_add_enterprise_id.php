<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOutboundInvoiceItemAddEnterpriseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outbound_invoice_items', function (Blueprint $table) {
            $table->uuid('vendor_id')->nullable()->after('mission_id');

            $table->foreign('vendor_id')->references('id')->on('enterprises')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
        });
    }
}
