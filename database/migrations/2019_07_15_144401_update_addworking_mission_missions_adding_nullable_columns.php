<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionMissionsAddingNullableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->integer('quantity')->default(null)->nullable()->change();
            $table->string('unit')->default(null)->nullable()->change();
            $table->float('unit_price')->default(null)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->change();
            $table->string('unit')->default('fixed_fees')->change();
            $table->float('unit_price')->default(0)->change();
        });
    }
}
