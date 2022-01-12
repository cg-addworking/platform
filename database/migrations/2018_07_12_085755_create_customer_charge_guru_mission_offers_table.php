<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerChargeGuruMissionOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_charge_guru_mission_offers', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_id');
            $table->uuid('vendor_id');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->primary('id');

            $table->unique(['mission_id', 'vendor_id']);

            $table
                ->foreign('mission_id')
                ->references('id')
                ->on('missions')
                ->onDelete('cascade');

            $table
                ->foreign('vendor_id')
                ->references('id')
                ->on('enterprises')
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
        Schema::dropIfExists('customer_charge_guru_mission_offers');
    }
}
