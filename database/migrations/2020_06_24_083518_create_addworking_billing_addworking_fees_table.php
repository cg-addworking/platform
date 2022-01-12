<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingBillingAddworkingFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_billing_addworking_fees', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('outbound_invoice_id');
            $table->uuid('invoice_parameter_id');
            $table->uuid('vat_rate_id');
            $table->uuid('customer_id');
            $table->uuid('outbound_invoice_item_id')->nullable();
            $table->uuid('vendor_id')->nullable();
            $table->string('label')->nullable();
            $table->string('type');
            $table->float('amount_before_taxes')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('outbound_invoice_id')
                ->references('id')->on('addworking_billing_outbound_invoices')
                ->onDelete('cascade');

            $table->foreign('invoice_parameter_id')
                ->references('id')->on('addworking_enterprise_invoice_parameters')
                ->onDelete('cascade');

            $table->foreign('customer_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('vat_rate_id')
                ->references('id')->on('addworking_billing_vat_rates')
                ->onDelete('cascade');

            $table->foreign('outbound_invoice_item_id')
                ->references('id')->on('addworking_billing_outbound_invoice_items')
                ->onDelete('cascade');

            $table->foreign('vendor_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_billing_addworking_fees');
    }
}
