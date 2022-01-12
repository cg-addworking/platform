<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionOffersHasDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_offers_has_departments', function (Blueprint $table) {
            $table->uuid('offer_id');
            $table->uuid('department_id');
            $table->timestamps();

            $table->primary(['offer_id', 'department_id']);

            $table
                ->foreign('offer_id')
                ->references('id')
                ->on('addworking_mission_offers')
                ->onDelete('cascade');

            $table
                ->foreign('department_id')
                ->references('id')
                ->on('addworking_common_departments')
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
        Schema::dropIfExists('addworking_mission_offers_has_departments');
    }
}
