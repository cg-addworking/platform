<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionOfferProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_offer_profiles', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('offer_id');
            $table->uuid('enterprise_id')->nullable();
            $table->uuid('user_id')->nullable();
            $table->uuid('selected_by');

            $table->string('status')->default('pre_selected');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('offer_id')
                ->references('id')
                ->on('addworking_mission_offers')
                ->onDelete('set null');

            $table
                ->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('set null');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');

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
        Schema::dropIfExists('addworking_mission_offer_profiles');
    }
}
