<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('missions', 'missions_old');
        Schema::rename('invoice_items', 'invoice_items_old');
        Schema::rename('invoices', 'invoices_old');

        Schema::create('missions', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('inbound_invoice_item_id')->nullable();
            $table->uuid('outbound_invoice_item_id')->nullable();
            $table->uuid('contract_id');
            $table->uuid('vendor_enterprise_id');
            $table->uuid('customer_enterprise_id');

            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->integer('quantity')->default(1);
            $table->float('unit_price')->default(0);
            $table->string('unit')->default('fixed_fees');
            $table->string('external_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('inbound_invoice_item_id')->references('id')->on('inbound_invoice_items')->onDelete('set null');
            $table->foreign('outbound_invoice_item_id')->references('id')->on('outbound_invoice_items')->onDelete('set null');
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->foreign('vendor_enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('customer_enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missions');

        Schema::rename('missions_old', 'missions');
        Schema::rename('invoice_items_old', 'invoice_items');
        Schema::rename('invoices_old', 'invoices');
    }
}
