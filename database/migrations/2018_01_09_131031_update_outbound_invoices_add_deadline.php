<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOutboundInvoicesAddDeadline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->string('deadline')->default('upon_receipt')->after('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('deadline');
        });
    }
}
