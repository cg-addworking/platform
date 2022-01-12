<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Webpatser\Uuid\Uuid;

class UpdateOutboundInvoiceCommentsTableTransferData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $outboundInvoices = DB::table('outbound_invoices')->get();

        foreach ($outboundInvoices as $invoice) {
            $enterpriseOutboundInvoices = DB::table('enterprise_outbound_invoice')
                ->where('outbound_invoice_id', $invoice->id)
                ->whereNotNull('comment')
                ->get();

            foreach ($enterpriseOutboundInvoices as $pivot) {
                DB::table('outbound_invoice_comments')->insert([
                    'id' => Uuid::generate(4),
                    'content' => $pivot->comment,
                    'vendor_id' => $pivot->vendor_id,
                    'outbound_invoice_id' => $pivot->outbound_invoice_id,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now(),
                ]);

                DB::table('enterprise_outbound_invoice')
                    ->where('outbound_invoice_id', $pivot->outbound_invoice_id)
                    ->where('vendor_id', $pivot->vendor_id)
                    ->update(['comment' => null]);
            }
        }

        /*
        Schema::table('enterprise_outbound_invoice', function (Blueprint $table) {
            $table->dropColumn('comment');
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::table('enterprise_outbound_invoice', function (Blueprint $table) {
            $table->text('comment')->nullable();
        });
        */

        $comments = DB::table('outbound_invoice_comments')->get();

        foreach ($comments as $comment) {
            DB::table('enterprise_outbound_invoice')
                ->where('outbound_invoice_id', $comment->outbound_invoice_id)
                ->where('vendor_id', $comment->vendor_id)
                ->update(['comment' => $comment->content]);
        }
    }
}
