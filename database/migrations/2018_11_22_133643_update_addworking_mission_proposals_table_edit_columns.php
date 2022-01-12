<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionProposalsTableEditColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->uuid('vendor_passwork_id')->nullable();

            $table
                ->foreign('vendor_passwork_id')
                ->references('id')
                ->on('sogetrel_user_passworks')
                ->onDelete('set null');
        });

        Schema::disableForeignKeyConstraints();

        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->dropColumn('vendor_user_id');
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
        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->uuid('vendor_user_id')->nullable();

            $table
                ->foreign('vendor_user_id')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');
        });

        Schema::table('addworking_mission_proposals', function (Blueprint $table) {
            $table->dropColumn('vendor_passwork_id');
        });
    }
}
