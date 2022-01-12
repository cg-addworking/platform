<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_purchase_orders', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_id');
            $table->uuid('file_id');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('mission_id')
                ->references('id')
                ->on('addworking_mission_missions')
                ->onDelete('cascade');

            $table->foreign('file_id')
                ->references('id')
                ->on('addworking_common_files')
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
        Schema::dropIfExists('addworking_mission_purchase_orders');
    }
}
