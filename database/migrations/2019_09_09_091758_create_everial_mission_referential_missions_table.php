<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEverialMissionReferentialMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('everial_mission_referential_missions', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('shipping_site');
            $table->string('shipping_address');
            $table->string('destination_site');
            $table->string('destination_address');
            $table->float('kilometer')->default(0);
            $table->integer('pallet_number')->default(0);
            $table->string('pallet_type')->nullable();
            $table->string('analytic_code')->nullable();
            $table->uuid('best_bidder_vendor_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('best_bidder_vendor_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
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
        Schema::dropIfExists('everial_mission_referential_missions');
    }
}
