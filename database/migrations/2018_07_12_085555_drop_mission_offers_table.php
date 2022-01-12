<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropMissionOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('mission_offers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('mission_offers', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_id');
            $table->uuid('vendor_id');
            $table->text('status');
            $table->timestamps();
            $table->primary('id');
            $table->softDeletes();
            $table->foreign('mission_id')->references('id')->on('missions')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('enterprises')->onDelete('cascade');
        });
    }
}
