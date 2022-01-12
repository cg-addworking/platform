<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEverialMissionPriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('everial_mission_price_lists', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('vendor_id');
            $table->uuid('referential_id');
            $table->float('amount')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('vendor_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('set null');

            $table->foreign('referential_id')
                ->references('id')
                ->on('everial_mission_referential_missions')
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
        Schema::dropIfExists('everial_mission_price_lists');
    }
}
