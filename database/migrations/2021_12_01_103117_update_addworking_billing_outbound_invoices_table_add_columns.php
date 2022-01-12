<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingOutboundInvoicesTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dateTime('validated_at')->nullable();
            $table->uuid('validated_by')->nullable();

            $table->foreign('validated_by')->references('id')->on('addworking_user_users')->onDelete('set null');
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
            $table->dropColumn('validated_by');
        });

        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('validated_at');
        });
    }
}
