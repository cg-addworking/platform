<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrateFilesOfInboundInvoivesInNewSystemPolymorphic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $inboundInvoices = DB::table('inbound_invoices')->select('id', 'file_id')->get();

        foreach ($inboundInvoices as $inboundInvoice) {
            if ($inboundInvoice->file_id) {
                DB::table('addworking_common_files')->where('id', $inboundInvoice->file_id)->update([
                    'attachable_id'   => $inboundInvoice->id,
                    'attachable_type' => "App\Models\Addworking\Billing\InboundInvoice"
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
        $inboundInvoices = DB::table('inbound_invoices')->select('id', 'file_id')->get();

        foreach ($inboundInvoices as $inboundInvoice) {
            if ($inboundInvoice->file_id) {
                DB::table('addworking_common_files')->where('id', $inboundInvoice->file_id)->update([
                    'attachable_id'   => null,
                    'attachable_type' => null
                ]);
            }
        }
    }
}
