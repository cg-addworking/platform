<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOutboundInvoiceAddMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->string('month')->nullable()->after('number');
        });

        foreach (DB::table('outbound_invoices')->select('id', 'date')->get() as $invoice) {
            DB::table('outbound_invoices')
                ->where('id', $invoice->id)
                ->update(['month' => date('m/Y', strtotime($invoice->date))]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('month');
        });
    }
}
