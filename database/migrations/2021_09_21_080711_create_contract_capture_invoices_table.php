<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractCaptureInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_capture_invoices', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_id');
            $table->uuid('customer_id');
            $table->uuid('vendor_id');
            $table->uuid('created_by');
            $table->integer('short_id');
            $table->string('invoice_number');
            $table->string('deposit_guaranteed_holdback_number')->nullable();
            $table->string('deposit_good_end_number')->nullable();
            $table->float('invoice_amount_before_taxes')->default(0);
            $table->float('invoice_amount_of_taxes')->default(0);
            $table->float('amount_guaranteed_holdback')->nullable();
            $table->float('amount_good_end')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('SET NULL');

            $table->foreign('customer_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('SET NULL');

            $table->foreign('vendor_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('SET NULL');

            $table->foreign('created_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_capture_invoices');
    }
}
