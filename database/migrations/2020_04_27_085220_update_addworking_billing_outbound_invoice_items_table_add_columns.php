<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class UpdateAddworkingBillingOutboundInvoiceItemsTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_outbound_invoice_items', function ($table) {
            $table->float('quantity')->change();
        });

        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->uuid('vat_rate_id')->nullable();
            $table->uuid('inbound_invoice_item_id')->nullable();

            $table->softDeletes();
            $table->uuid('deleted_by')->nullable();

            $table
                ->foreign('vat_rate_id')
                ->references('id')
                ->on('addworking_billing_vat_rates')
                ->onDelete('set null');

            $table
                ->foreign('inbound_invoice_item_id')
                ->references('id')
                ->on('addworking_billing_inbound_invoice_items')
                ->onDelete('set null');

            $table
                ->foreign('deleted_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');
        });

        $vat_rates_20 = [
            "0.20002",
            "0.2",
            "0.002",
            "2.02e-05",
            "2e-05",
            "0.00202",
        ];

        $outbound_invoice_items = DB::table('addworking_billing_outbound_invoice_items')->get();

        foreach ($outbound_invoice_items as $item) {
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

                DB::table('addworking_billing_outbound_invoice_items')->where('id', $item->id)->update([
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

                DB::table('addworking_billing_outbound_invoice_items')->where('id', $item->id)->update([
                    'vat_rate_id' => $vat_rate_0_id,
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
        Schema::table('addworking_billing_outbound_invoice_items', function ($table) {
            $table->integer('quantity')->change();
        });

        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('vat_rate_id');
        });

        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('addworking_billing_outbound_invoice_items', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });
    }
}
