<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostEstimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_cost_estimations', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('file_id')->nullable();
            $table->float('amount_before_taxes')->default(0);
            $table->timestamps();

            $table->primary('id');
            $table->foreign('file_id')
                ->references('id')
                ->on('addworking_common_files')
                ->onDelete('cascade');
        });

        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->uuid('cost_estimation_id')->nullable();

            $table->foreign('cost_estimation_id')
                ->references('id')
                ->on('mission_cost_estimations')
                ->onDelete('cascade');
        });

        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->uuid('cost_estimation_id')->nullable();

            $table->foreign('cost_estimation_id')
                ->references('id')
                ->on('mission_cost_estimations')
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
        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->dropColumn('cost_estimation_id');
        });
        Schema::table('addworking_mission_offers', function (Blueprint $table) {
            $table->dropColumn('cost_estimation_id');
        });
        Schema::dropIfExists('mission_cost_estimations');
    }
}
