<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInboundInvoicesAddOutboundInvoiceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbound_invoices', function (Blueprint $table) {
            $table->uuid('outbound_invoice_id')->nullable();

            $table->foreign('outbound_invoice_id')->references('id')->on('outbound_invoices')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('outbound_invoice_id');
        });
    }
}
