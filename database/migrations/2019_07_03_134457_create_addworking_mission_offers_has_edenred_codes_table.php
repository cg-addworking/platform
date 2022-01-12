<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionOffersHasEdenredCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_offers_has_edenred_codes', function (Blueprint $table) {
            $table->uuid('offer_id');
            $table->uuid('code_id');

            $table->primary(['offer_id', 'code_id']);

            $table
                ->foreign('offer_id')
                ->references('id')
                ->on('addworking_mission_offers')
                ->onDelete('cascade');

            $table
                ->foreign('code_id')
                ->references('id')
                ->on('edenred_common_codes')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_mission_offers_has_edenred_codes');
    }
}
