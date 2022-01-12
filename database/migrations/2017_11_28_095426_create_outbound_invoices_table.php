<?php

use App\Contracts\Billing\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutboundInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbound_invoices', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->uuid('file_id')->nullable();
            $table->string('status')->default(Invoice::STATUS_TO_VALIDATE);
            $table->string('number');
            $table->date('date');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('set null');
        });

        Schema::create('outbound_invoice_items', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('outbound_invoice_id');
            $table->string('label');
            $table->integer('quantity')->default(1);
            $table->float('unit_price')->default(0);
            $table->float('vat_rate')->default(config('billing.vat_rate'));
            $table->boolean('accepted')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('outbound_invoice_id')->references('id')->on('outbound_invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outbound_invoice_items');
        Schema::dropIfExists('outbound_invoices');
    }
}
