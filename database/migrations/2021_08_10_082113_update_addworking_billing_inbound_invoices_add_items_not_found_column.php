<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingInboundInvoicesAddItemsNotFoundColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->boolean('items_not_found')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('items_not_found');
        });
    }
}
