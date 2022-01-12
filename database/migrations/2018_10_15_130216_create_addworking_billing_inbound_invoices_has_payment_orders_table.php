<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingBillingInboundInvoicesHasPaymentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_billing_inbound_invoices_has_payment_orders', function (Blueprint $table) {
            $table->uuid('inbound_invoice_id');
            $table->uuid('outbound_invoice_payment_order_id');
            $table->timestamps();

            $table->primary(['inbound_invoice_id', 'outbound_invoice_payment_order_id']);

            $table
                ->foreign('inbound_invoice_id')
                ->references('id')->on('inbound_invoices')
                ->onDelete('cascade');

            $table
                ->foreign('outbound_invoice_payment_order_id')
                ->references('id')->on('outbound_invoice_payment_orders')
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
        Schema::dropIfExists('addworking_billing_inbound_invoices_has_payment_orders');
    }
}
