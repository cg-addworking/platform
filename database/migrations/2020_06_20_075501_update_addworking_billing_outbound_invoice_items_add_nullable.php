<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingOutboundInvoiceItemsAddNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->uuid('vendor_id')->nullable()->change();
            $table->uuid('inbound_invoice_item_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->uuid('vendor_id')->change();
            $table->uuid('inbound_invoice_item_id')->change();
        });
    }
}
