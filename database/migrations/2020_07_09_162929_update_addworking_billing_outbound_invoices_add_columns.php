<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingOutboundInvoicesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->boolean('reverse_charge_vat')->default(false);
        });

        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->boolean('dailly_assignment')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('reverse_charge_vat');
        });

        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('dailly_assignment');
        });
    }
}
