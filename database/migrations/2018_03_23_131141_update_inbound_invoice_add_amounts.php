<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInboundInvoiceAddAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbound_invoices', function (Blueprint $table) {
            $table->float('admin_amount')->nullable();
            $table->float('admin_amount_of_taxes')->nullable();
            $table->float('admin_amount_all_taxes_included')->nullable();
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
            $table->dropColumn('admin_amount')->nullable();
        });

        Schema::table('inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('admin_amount_of_taxes')->nullable();
        });

        Schema::table('inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('admin_amount_all_taxes_included')->nullable();
        });
    }
}
