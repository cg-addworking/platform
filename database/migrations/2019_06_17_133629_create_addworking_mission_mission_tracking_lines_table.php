<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionMissionTrackingLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('tracking_id');
            $table->string('label')->nullable();
            $table->float('quantity')->default(1);
            $table->string('unit');
            $table->float('unit_price')->default(0);
            $table->boolean('validated_vendor')->default(false);
            $table->boolean('validated_customer')->default(false);
            $table->string('reason_for_rejection')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('tracking_id')
                ->references('id')->on('addworking_mission_mission_trackings')
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
        Schema::dropIfExists('addworking_mission_mission_tracking_lines');
    }
}
