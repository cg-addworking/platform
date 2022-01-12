<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrateFilesOfOutboundInvoivesInNewSystemPolymorphic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $outboundInvoices = DB::table('outbound_invoices')->select('id', 'file_id')->get();

        foreach ($outboundInvoices as $outboundInvoice) {
            if ($outboundInvoice->file_id) {
                DB::table('addworking_common_files')->where('id', $outboundInvoice->file_id)->update([
                    'attachable_id'   => $outboundInvoice->id,
                    'attachable_type' => "App\Models\Addworking\Billing\outboundInvoice"
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $outboundInvoices = DB::table('outbound_invoices')->select('id', 'file_id')->get();

        foreach ($outboundInvoices as $outboundInvoice) {
            if ($outboundInvoice->file_id) {
                DB::table('addworking_common_files')->where('id', $outboundInvoice->file_id)->update([
                    'attachable_id'   => null,
                    'attachable_type' => null
                ]);
            }
        }
    }
}
