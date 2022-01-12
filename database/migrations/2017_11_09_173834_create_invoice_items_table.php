<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('invoice_id');
            $table->uuid('mission_id')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->string('label');
            $table->integer('quantity')->default(1);
            $table->float('unit_amount');
            $table->float('vat_rate')->default(.2);

            $table->timestamps();
            $table->primary('id');

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('mission_id')->references('id')->on('missions')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('invoice_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
