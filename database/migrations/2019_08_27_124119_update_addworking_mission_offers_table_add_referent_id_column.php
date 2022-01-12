<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionOffersTableAddReferentIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->uuid('referent_id')->nullable();

            $table
                ->foreign('referent_id')
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
        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->dropColumn('referent_id');
        });
    }
}
