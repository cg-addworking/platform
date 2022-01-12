<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->uuid('outbound_invoice_id')->nullable()->change();
        });

        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->uuid('enterprise_id')->nullable();

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('set null');
        });

        Schema::table('addworking_billing_payment_order_items', function (Blueprint $table) {
            $table->uuid('outbound_invoice_id')->nullable();

            $table->foreign('outbound_invoice_id')
                ->references('id')->on('addworking_billing_outbound_invoices')
                ->onDelete('set null');
        });

        $payment_orders = DB::table('addworking_billing_payment_orders')->get();
        foreach ($payment_orders as $order) {
            $outbound_invoice = DB::table('addworking_billing_outbound_invoices')->find($order->outbound_invoice_id);
            DB::table('addworking_billing_payment_orders')->where('id', $order->id)
                ->update(['enterprise_id' => $outbound_invoice->enterprise_id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_payment_orders', function (Blueprint $table) {
            $table->dropColumn('enterprise_id');
        });

        Schema::table('addworking_billing_payment_order_items', function (Blueprint $table) {
            $table->dropColumn('outbound_invoice_id');
        });
    }
}
