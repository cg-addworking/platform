<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingInboundInvoicesAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->string('compliance_status')->default('pending');
        });

        DB::table('addworking_billing_inbound_invoices')->where('status','validated')->update([
            'compliance_status' => 'valid',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('compliance_status');
        });
    }
}
