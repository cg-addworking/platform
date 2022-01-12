<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingReceivedPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_received_payments', function (Blueprint $table) {
            $table->dropColumn('outbound_invoice_id');
        });

        Schema::table('addworking_billing_received_payments', function (Blueprint $table) {
            $table->uuid('enterprise_id')->nullable();

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
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
        Schema::table('addworking_billing_received_payments', function (Blueprint $table) {
            $table->dropColumn('enterprise_id');
        });

        Schema::table('addworking_billing_received_payments', function (Blueprint $table) {
            $table->uuid('outbound_invoice_id')->nullable();
            $table->foreign('outbound_invoice_id')
                ->references('id')->on('addworking_billing_outbound_invoices')
                ->onDelete('set null');
        });
    }
}
