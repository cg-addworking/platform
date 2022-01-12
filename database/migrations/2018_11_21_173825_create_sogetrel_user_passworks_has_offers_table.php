<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSogetrelUserPassworksHasOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_user_passworks_has_offers', function (Blueprint $table) {
            $table->uuid('offer_id');
            $table->uuid('passwork_id');

            $table->uuid('selected_by')->nullable();
            $table->string('status')->default('pre_selected');
            $table->timestamps();

            $table->primary(['offer_id', 'passwork_id']);

            $table
                ->foreign('offer_id')
                ->references('id')
                ->on('addworking_mission_offers')
                ->onDelete('cascade');

            $table
                ->foreign('passwork_id')
                ->references('id')
                ->on('sogetrel_user_passworks')
                ->onDelete('cascade');

            $table
                ->foreign('selected_by')
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
        Schema::dropIfExists('sogetrel_user_passworks_has_offers');
    }
}
