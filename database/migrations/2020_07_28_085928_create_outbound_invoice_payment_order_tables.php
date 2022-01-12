<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutboundInvoicePaymentOrderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('addworking_billing_outbound_invoice_payment_orders', 'addworking_billing_payment_orders');

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->uuid('iban_id')->nullable();
            $table->integer('number')->default(0);
            $table->string('debtor_name')->nullable();
            $table->string('debtor_iban')->nullable();
            $table->string('debtor_bic')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('bank_reference_payment')->nullable();
            $table->dateTime('executed_at')->nullable();
            $table->uuid('created_by')->nullable();
            $table->softDeletes();

            $table->foreign('iban_id')
                ->references('id')->on('addworking_enterprise_ibans')
                ->onDelete('set null');
        });

        Schema::create('addworking_billing_payment_order_items', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('payment_order_id');
            $table->uuid('inbound_invoice_id');
            $table->uuid('iban_id');
            $table->integer('number')->default(0);
            $table->string('enterprise_name')->nullable();
            $table->string('enterprise_iban')->nullable();
            $table->string('enterprise_bic')->nullable();
            $table->float('amount')->default(0);
            $table->uuid('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('payment_order_id')
                ->references('id')->on('addworking_billing_payment_orders')
                ->onDelete('cascade');

            $table->foreign('inbound_invoice_id')
                ->references('id')->on('addworking_billing_inbound_invoices')
                ->onDelete('set null');

            $table->foreign('iban_id')
                ->references('id')->on('addworking_enterprise_ibans')
                ->onDelete('set null');
        });

        Schema::create('addworking_billing_received_payments', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('outbound_invoice_id');
            $table->uuid('iban_id');
            $table->integer('number')->default(0);
            $table->string('bank_reference_payment')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->float('amount')->default(0);
            $table->dateTime('received_at')->nullable();
            $table->uuid('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('outbound_invoice_id')
                ->references('id')->on('addworking_billing_outbound_invoices')
                ->onDelete('set null');

            $table->foreign('iban_id')
                ->references('id')->on('addworking_enterprise_ibans')
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
        Schema::dropIfExists('addworking_billing_received_payments');
        Schema::dropIfExists('addworking_billing_payment_order_items');

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('iban_id');
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('number');
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('debtor_name');
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('debtor_bic');
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('debtor_iban');
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('customer_name');
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('bank_reference_payment');
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('executed_at');
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::rename('addworking_billing_payment_orders', 'addworking_billing_outbound_invoice_payment_orders');
    }
}
