<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixEnterpriseOutboundInvoicesTablePermuteVendorIdOutboundinvoiceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_outbound_invoice_copy', function (Blueprint $table) {
            $table->uuid('vendor_id');
            $table->uuid('outbound_invoice_id');
            $table->string('status')->default('to_validate');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->primary(['vendor_id', 'outbound_invoice_id']);

            $table->foreign('outbound_invoice_id')->references('id')->on('outbound_invoices')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('enterprises')->onDelete('cascade');
        });


        foreach (DB::table('enterprise_outbound_invoice')->get() as $invoice) {
            try {
                $vendor_id = DB::table('enterprises')
                    ->select('id')
                    ->where('id', $invoice->outbound_invoice_id)
                    ->orWhere('id', $invoice->vendor_id)
                    ->firstOrFail()
                    ->id;

                $outbound_invoice_id = DB::table('outbound_invoices')
                    ->select('id')
                    ->where('id', $invoice->outbound_invoice_id)
                    ->orWhere('id', $invoice->vendor_id)
                    ->firstOrFail()
                    ->id;

                DB::table('enterprise_outbound_invoice_copy')
                    ->insert([
                        'vendor_id'           => $vendor_id,
                        'outbound_invoice_id' => $outbound_invoice_id,
                        'status'              => $invoice->status,
                        'comment'             => $invoice->comment,
                    ]);
            } catch (\Exception $e) {
                continue;
            }
        }

        Schema::drop('enterprise_outbound_invoice');
        Schema::rename('enterprise_outbound_invoice_copy', 'enterprise_outbound_invoice');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('enterprise_outbound_invoice', 'enterprise_outbound_invoice_copy');

        Schema::create('enterprise_outbound_invoice', function (Blueprint $table) {
            $table->uuid('vendor_id');
            $table->uuid('outbound_invoice_id');
            $table->string('status')->default('to_validate');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->primary(['vendor_id', 'outbound_invoice_id']);
        });

        foreach (DB::table('enterprise_outbound_invoice_copy')->get() as $invoice) {
            DB::table('enterprise_outbound_invoice')
                ->insert([
                    'vendor_id'           => $invoice->outbound_invoice_id,
                    'outbound_invoice_id' => $invoice->vendor_id,
                    'status'              => $invoice->status,
                    'comment'             => $invoice->comment,
                ]);
        }

        Schema::drop('enterprise_outbound_invoice_copy');
    }
}
