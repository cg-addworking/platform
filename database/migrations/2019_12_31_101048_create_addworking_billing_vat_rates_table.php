<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingBillingVatRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_billing_vat_rates', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('display_name');
            $table->float('value');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('deleted_by')->nullable();

            $table->primary('id');

            $table
                ->foreign('deleted_by')
                ->references('id')
                ->on('addworking_user_users')
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
        Schema::dropIfExists('addworking_billing_vat_rates');
    }
}
