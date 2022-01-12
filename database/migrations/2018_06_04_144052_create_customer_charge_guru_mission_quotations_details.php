<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerChargeGuruMissionQuotationsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_charge_guru_mission_quotations_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('intervention_delay');
            $table->integer('intervention_duration');
            $table->json('subscription');
            $table->integer('subscription_price_ht');
            $table->json('quotation_item');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_charge_guru_mission_quotations_details');
    }
}
