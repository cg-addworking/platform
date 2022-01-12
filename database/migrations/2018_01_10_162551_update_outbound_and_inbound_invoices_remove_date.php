<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOutboundAndInboundInvoicesRemoveDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('date');
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
            $table->date('date')->nullable()->after('month');
        });

        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->date('date')->nullable()->after('month');
        });
    }
}
