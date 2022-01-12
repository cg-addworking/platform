<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContractCaptureInvoicesTableAddContractNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_capture_invoices', function (Blueprint $table) {
            $table->integer('contract_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_capture_invoices', function (Blueprint $table) {
            $table->dropColumn('contract_number');
        });
    }
}
