<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->uuid('file_id')->nullable();
            $table->string('number');
            $table->date('date');
            $table->float('amount_tax_free');
            $table->float('amount_vat');
            $table->float('amount_all_taxes_included');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('set null');
        });

        Schema::create('enterprise_invoice', function (Blueprint $table) {
            $table->uuid('invoice_id');
            $table->uuid('enterprise_id');
            $table->primary(['invoice_id', 'enterprise_id']);

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_invoice');
        Schema::dropIfExists('invoices');
    }
}
