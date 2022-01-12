<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionOffersTableDeleteColumnFileId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->dropColumn('file_id');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->uuid('file_id')->nullable();

            $table
                ->foreign('file_id')
                ->references('id')
                ->on('addworking_common_files')
                ->onDelete('set null');
        });
    }
}
