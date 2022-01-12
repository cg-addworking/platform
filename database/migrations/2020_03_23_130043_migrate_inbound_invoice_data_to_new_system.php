<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class MigrateInboundInvoiceDataToNewSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $vat_rates_20 = [
            "0.20002",
            "0.2",
            "0.002",
            "2.02e-05",
            "2e-05",
            "0.00202",
        ];

        $inbound_invoice_items = DB::table('addworking_billing_inbound_invoice_items')->get();

        foreach ($inbound_invoice_items as $item) {
            if (in_array($item->vat_rate, $vat_rates_20)) {
                $vat_rate_20 = DB::table('addworking_billing_vat_rates')->where('value', 0.2)->first();

                if (is_null($vat_rate_20)) {
                    $vat_rate_20_id = DB::table('addworking_billing_vat_rates')->insertGetId([
                        'id'           => Uuid::generate(4),
                        'name'         => "tva_20_percent",
                        'display_name' => "TVA 20%",
                        'value'        => 0.2,
                        'created_at'   => Carbon::now(),
                        'updated_at'   => Carbon::now()
                    ]);
                } else {
                    $vat_rate_20_id = $vat_rate_20->id;
                }

                DB::table('addworking_billing_inbound_invoice_items')->where('id', $item->id)->update([
                    'vat_rate_id' => $vat_rate_20_id,
                ]);
            } else {
                $vat_rate_0 = DB::table('addworking_billing_vat_rates')->where('value', 0)->first();

                if (is_null($vat_rate_0)) {
                    $vat_rate_0_id = DB::table('addworking_billing_vat_rates')->insertGetId([
                        'id'           => Uuid::generate(4),
                        'name'         => "tva_0_percent",
                        'display_name' => "TVA 0%",
                        'value'        => 0,
                        'created_at'   => Carbon::now(),
                        'updated_at'   => Carbon::now()
                    ]);
                } else {
                    $vat_rate_0_id = $vat_rate_0->id;
                }

                DB::table('addworking_billing_inbound_invoice_items')->where('id', $item->id)->update([
                    'vat_rate_id' => $vat_rate_0_id,
                ]);
            }
        }

        $invoices = DB::table('addworking_billing_inbound_invoices')->get();

        foreach ($invoices as $invoice) {
            switch ($invoice->deadline) {
                case 'upon_receipt':
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 0)->first();
                    break;
                case '30_days':
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 30)->first();
                    break;
                case '40_days':
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 40)->first();
                    break;
                default:
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 30)->first();
            }

            DB::table('addworking_billing_inbound_invoices')->where('id', $invoice->id)->update([
                'invoiced_at'         => Carbon::parse($invoice->created_at)->startOfDay(),
                'due_at'              => Carbon::parse($invoice->created_at)->addDays($deadline->value)->endOfDay(),
                'deadline_id'         => $deadline->id,
                'amount_before_taxes' => $invoice->admin_amount ?? 0,
                'amount_of_taxes'     => $invoice->admin_amount_of_taxes ?? 0,
                'amount_all_taxes_included' => $invoice->admin_amount_all_taxes_included ?? 0,
            ]);
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
