<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevertOutboundInvoicesAttachmentsToFileId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $outbound_invoice_ids = DB::table('outbound_invoices')->select('id')->pluck('id');

        foreach ($outbound_invoice_ids as $outbound_invoice_id) {
            $file = DB::table('addworking_common_files')
                ->where('attachable_type', "App\Models\Addworking\Billing\OutboundInvoice")
                ->where('attachable_id', $outbound_invoice_id)
                ->latest()
                ->first();

            if (is_null($file)) {
                continue;
            }

            DB::table('outbound_invoices')
                ->where('id', $outbound_invoice_id)
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
