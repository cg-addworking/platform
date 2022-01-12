<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContractsAddVendorIdAndCustomerIdColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->uuid('vendor_id')->nullable();
            $table->uuid('customer_id')->nullable();

            $table
                ->foreign('vendor_id')
                ->references('id')->on('enterprises')
                ->onDelete('set null');

            $table
                ->foreign('customer_id')
                ->references('id')->on('enterprises')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
    }
}
