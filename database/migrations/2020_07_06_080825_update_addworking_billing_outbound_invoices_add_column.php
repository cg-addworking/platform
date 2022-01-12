<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingOutboundInvoicesAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->boolean('is_published')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }
}
