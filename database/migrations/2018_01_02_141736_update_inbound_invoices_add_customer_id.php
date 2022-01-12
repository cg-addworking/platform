<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInboundInvoicesAddCustomerId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbound_invoices', function (Blueprint $table) {
            $table->uuid('customer_id')->nullable();

            $table->foreign('customer_id')->references('id')->on('enterprises')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
    }
}
