<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTseExpressMedicalMissionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_tse_express_medical_mission_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_id');
            $table->integer('gasoil_tax');
            $table->integer('equipment_rental');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->foreign('mission_id')->references('id')->on('missions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_tse_express_medical_mission_details');
    }
}
