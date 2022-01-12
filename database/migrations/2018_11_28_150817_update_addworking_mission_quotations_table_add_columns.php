<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionQuotationsTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->uuid('quotable_id')->nullable();
            $table->string('quotable_type')->nullable();
        });

        Schema::disableForeignKeyConstraints();
        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->dropColumn('mission_id');
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
        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->uuid('mission_id')->nullable();

            $table
                ->foreign('mission_id')
                ->references('id')
                ->on('addworking_mission_missions')
                ->onDelete('cascade');
        });

        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->dropColumn('quotable_type');
        });

        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->dropColumn('quotable_id');
        });
    }
}
