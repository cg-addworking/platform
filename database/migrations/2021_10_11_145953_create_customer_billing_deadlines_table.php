<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBillingDeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_billing_deadlines', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->uuid('deadline_id');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('SET NULL');

            $table->foreign('deadline_id')
                ->references('id')->on('addworking_billing_deadline_types')
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
        Schema::dropIfExists('customer_billing_deadlines');
    }
}
