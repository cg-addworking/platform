<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingInboundInvoiceItemsTableAddInvoiceable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_inbound_invoice_items', function (Blueprint $table) {
            $table->uuid('invoiceable_id')->nullable();
            $table->string('invoiceable_type')->nullable();
            $table->uuid('vat_rate_id')->nullable();
            $table->float('amount_before_taxes')->default(0);
            $table->float('amount_of_taxes')->default(0);
            $table->string('analytic_code')->nullable();
            $table->softDeletes();
            $table->uuid('deleted_by')->nullable();

            $table
                ->foreign('vat_rate_id')
                ->references('id')
                ->on('addworking_billing_vat_rates')
                ->onDelete('set null');

            $table
                ->foreign('deleted_by')
                ->references('id')
                ->on('addworking_user_users')
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
        Schema::table('addworking_billing_inbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('invoiceable_id');
        });

        Schema::table('addworking_billing_inbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('invoiceable_type');
        });

        Schema::table('addworking_billing_inbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('vat_rate_id');
        });

        Schema::table('addworking_billing_inbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('amount_before_taxes');
        });

        Schema::table('addworking_billing_inbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('amount_of_taxes');
        });

        Schema::table('addworking_billing_inbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('analytic_code');
        });

        Schema::table('addworking_billing_inbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('addworking_billing_inbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });
    }
}
