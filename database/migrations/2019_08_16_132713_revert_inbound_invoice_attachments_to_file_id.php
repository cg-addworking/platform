<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevertInboundInvoiceAttachmentsToFileId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $inbound_invoice_ids = DB::table('inbound_invoices')->select('id')->pluck('id');

        foreach ($inbound_invoice_ids as $inbound_invoice_id) {
            $file = DB::table('addworking_common_files')
                ->where('attachable_type', "App\Models\Addworking\Billing\InboundInvoice")
                ->where('attachable_id', $inbound_invoice_id)
                ->latest()
                ->first();

            if (is_null($file)) {
                continue;
            }

            DB::table('inbound_invoices')
                ->where('id', $inbound_invoice_id)
                ->update(['file_id' => $file->id]);
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
