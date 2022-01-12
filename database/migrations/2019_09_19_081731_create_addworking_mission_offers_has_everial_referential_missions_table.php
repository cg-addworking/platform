<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionOffersHasEverialReferentialMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_offers_has_everial_referential_missions', function (Blueprint $table) {
            $table->uuid('offer_id');
            $table->uuid('referential_id');

            $table->timestamps();
            $table->softDeletes();

            $table->primary(['offer_id', 'referential_id']);

            $table->foreign('offer_id')
                ->references('id')
                ->on('addworking_mission_offers')
                ->onDelete('cascade');

            $table->foreign('referential_id')
                ->references('id')
                ->on('everial_mission_referential_missions')
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
        Schema::dropIfExists('addworking_mission_offers_has_everial_referential_missions');
    }
}
