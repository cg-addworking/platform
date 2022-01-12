<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionOffersHasFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_offers_has_files', function (Blueprint $table) {
            $table->uuid('offer_id');
            $table->uuid('file_id');
            $table->timestamps();

            $table->primary(['offer_id', 'file_id']);

            $table
                ->foreign('offer_id')
                ->references('id')
                ->on('addworking_mission_offers')
                ->onDelete('cascade');

            $table
                ->foreign('file_id')
                ->references('id')
                ->on('addworking_common_files')
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
        Schema::dropIfExists('addworking_mission_offers_has_files');
    }
}
