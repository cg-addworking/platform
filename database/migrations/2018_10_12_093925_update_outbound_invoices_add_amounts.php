<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOutboundInvoicesAddAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->float('amount')->nullable();
            $table->float('amount_vat')->nullable();
            $table->float('amount_all_taxes_included')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('amount');
        });

        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('amount_vat');
        });

        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('amount_all_taxes_included');
        });
    }
}
