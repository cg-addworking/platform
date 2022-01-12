<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteAddworkingOutboundInvoiceItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $addworking = DB::table('addworking_enterprise_enterprises')->where('name', 'ADDWORKING')->first();

        if (! is_null($addworking)) {
            DB::table('outbound_invoice_items')->where('vendor_id', $addworking->id)->delete();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
