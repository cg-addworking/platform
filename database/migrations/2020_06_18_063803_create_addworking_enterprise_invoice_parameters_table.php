<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseInvoiceParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->uuid('iban_id')->nullable();
            $table->string('analytic_code')->nullable();
            $table->date('discount_starts_at')->nullable();
            $table->date('discount_ends_at')->nullable();
            $table->float('discount_amount')->default(0);
            $table->float('billing_floor_amount')->default(0);
            $table->float('billing_cap_amount')->default(0);
            $table->float('default_management_fees_by_vendor', 0, 1)->default(0);
            $table->float('custom_management_fees_by_vendor', 0, 1)->default(0);
            $table->float('fixed_fees_by_vendor_amount')->default(0);
            $table->float('subscription_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('iban_id')
                ->references('id')->on('addworking_enterprise_ibans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_enterprise_invoice_parameters');
    }
}
