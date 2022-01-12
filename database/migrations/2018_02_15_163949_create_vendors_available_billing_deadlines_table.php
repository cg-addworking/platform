<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsAvailableBillingDeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors_available_billing_deadlines', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('customer_id');
            $table->uuid('vendor_id');
            $table->timestamps();
            $table->primary('id');
            $table->boolean('upon_receipt')->nullable();
            $table->boolean('30_days')->nullable();
            $table->softDeletes();
            $table->foreign('customer_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('enterprises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors_available_billing_deadlines');
    }
}
