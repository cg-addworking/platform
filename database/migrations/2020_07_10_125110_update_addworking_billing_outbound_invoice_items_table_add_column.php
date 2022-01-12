<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingOutboundInvoiceItemsTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->integer('number')->default(0);
        });

        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->boolean('is_canceled')->default(false);
        });

        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->uuid('parent_id')->nullable();

            $table
                ->foreign('parent_id')
                ->references('id')
                ->on('addworking_billing_outbound_invoice_items')
                ->onDelete('set null');
        });

        $items = DB::table('addworking_billing_outbound_invoice_items')->get();
        $num = 0;

        foreach ($items as $item) {
            $num ++;

            DB::table('addworking_billing_outbound_invoice_items')
                ->where('id', $item->id)
                ->update(['number' => $num]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('number');
        });

        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('is_canceled');
        });

        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
}
