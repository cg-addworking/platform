<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVendorsAvailableBillingDeadlinesTableAdd40Days extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors_available_billing_deadlines', function (Blueprint $table) {
            $table->boolean('40_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors_available_billing_deadlines', function (Blueprint $table) {
            // @todo repair this! it breaks on SQLite
            //$table->dropColumn('40_days');
        });
    }
}
