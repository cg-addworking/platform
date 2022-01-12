<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingOutboundInvoicesTabeAddNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->integer('number')->default(0);
        });

        $numbers = DB::table('addworking_billing_outbound_invoice_numbers')->get();

        foreach ($numbers as $number) {
            $num = explode('_', $number->number);
            if (! isset($num[2])) {
                $num = explode('-', $number->number);
            }

            DB::table('addworking_billing_outbound_invoices')
                ->where('id', $number->outbound_invoice_id)
                ->update(['number' => $num[2]]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
