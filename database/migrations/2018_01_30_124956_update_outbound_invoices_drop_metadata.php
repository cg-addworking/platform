<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOutboundInvoicesDropMetadata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rows = DB::table('outbound_invoices')->select('id', 'metadata')->whereNotNull('metadata')->get();

        foreach ($rows as $row) {
            $outbound_invoice_id = $row->id;
            $data = $row->metadata;

            while (is_string($data)) {
                $data = json_decode($data, true);
            }

            foreach ($data['status'] ?? [] as $vendor_id => $status) {
                if (!is_uuid($vendor_id)) {
                    continue;
                }

                DB::table('enterprise_outbound_invoice')->updateOrInsert(
                    @compact('outbound_invoice_id', 'vendor_id'),
                    @compact('status')
                );
            }

            foreach ($data['comment'] ?? [] as $vendor_id => $comment) {
                if (!is_uuid($vendor_id)) {
                    continue;
                }

                DB::table('enterprise_outbound_invoice')->updateOrInsert(
                    @compact('outbound_invoice_id', 'vendor_id'),
                    @compact('comment')
                );
            }
        }

        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('metadata');
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
            $table->json('metadata')->nullable()->after('deadline');
        });
    }
}
