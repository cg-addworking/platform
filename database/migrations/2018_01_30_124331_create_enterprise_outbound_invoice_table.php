<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterpriseOutboundInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_outbound_invoice', function (Blueprint $table) {
            $table->uuid('vendor_id');
            $table->uuid('outbound_invoice_id');
            $table->string('status')->default('to_validate');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->primary(['vendor_id', 'outbound_invoice_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_outbound_invoice');
    }
}
