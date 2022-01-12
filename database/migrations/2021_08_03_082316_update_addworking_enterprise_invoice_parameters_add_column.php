<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseInvoiceParametersAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->boolean('vendor_creating_inbound_invoice_items')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->dropColumn('vendor_creating_inbound_invoice_items');
        });
    }
}
