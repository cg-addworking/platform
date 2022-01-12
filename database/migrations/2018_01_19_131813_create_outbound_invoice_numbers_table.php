<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class CreateOutboundInvoiceNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbound_invoice_numbers', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('number')->unique();
            $table->uuid('outbound_invoice_id')->nullable();
            $table->uuid('requested_by')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');

            $table->foreign('outbound_invoice_id')->references('id')->on('outbound_invoices')->onDelete('set null');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('set null');
        });

        $inserts = [];
        foreach (DB::table('outbound_invoices')->select('id', 'number')->where('number', '!=', '')->get() as $invoice) {
            if ($invoice->number == 'n/a') {
                continue;
            }

            $inserts[] = [
                'id'                  => Uuid::generate(4),
                'number'              => $invoice->number,
                'outbound_invoice_id' => $invoice->id,
                'created_at'          => Carbon\Carbon::now(),
                'updated_at'          => Carbon\Carbon::now(),
            ];
        }

        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('number');
        });

        DB::table('outbound_invoice_numbers')->insert($inserts);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->string('number')->default('n/a')->after('status');
        });

        foreach (DB::table('outbound_invoice_numbers')->select('number', 'outbound_invoice_id')->get() as $number) {
            DB::table('outbound_invoices')->where('id', $number->outbound_invoice_id)->update([
                'number' => $number->number,
            ]);
        }

        Schema::dropIfExists('outbound_invoice_numbers');
    }
}
