<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOutboundInvoicePaymentOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbound_invoice_payment_orders', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('outbound_invoice_id');
            $table->uuid('file_id');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('outbound_invoice_id')->references('id')->on('outbound_invoices')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::create('enterprise_outbound_invoice_payment_order', function (Blueprint $table) {
            $table->uuid('outbound_invoice_payment_order_id');
            $table->uuid('enterprise_id');
            $table->primary(['outbound_invoice_payment_order_id', 'enterprise_id']);

            $table
                ->foreign('outbound_invoice_payment_order_id')
                ->references('id')
                ->on('outbound_invoice_payment_orders')
                ->onDelete('cascade');

            $table
                ->foreign('enterprise_id')
                ->references('id')
                ->on('enterprises')
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
        Schema::dropIfExists('enterprise_outbound_invoice_payment_order');
        Schema::dropIfExists('outbound_invoice_payment_orders');
    }
}
