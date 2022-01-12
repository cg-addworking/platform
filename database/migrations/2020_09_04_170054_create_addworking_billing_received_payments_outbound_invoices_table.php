<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingBillingReceivedPaymentsOutboundInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_billing_received_payments_outbound_invoices', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('outbound_invoice_id');
            $table->uuid('received_payment_id');
            $table->timestamps();

            $table->primary('id');

            $table->unique(['outbound_invoice_id', 'received_payment_id'], 'received_payment_outbound_invoice');

            $table->foreign('outbound_invoice_id')
                ->references('id')->on('addworking_billing_outbound_invoices')
                ->onDelete('set null');

            $table->foreign('received_payment_id')
                ->references('id')->on('addworking_billing_received_payments')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_billing_received_payments_outbound_invoices');
    }
}
