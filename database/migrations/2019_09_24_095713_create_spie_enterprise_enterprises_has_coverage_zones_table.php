<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpieEnterpriseEnterprisesHasCoverageZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spie_enterprise_enterprises_has_coverage_zones', function (Blueprint $table) {
            $table->uuid('enterprise_id');
            $table->uuid('coverage_zone_id');
            $table->boolean('active')->nullable()->default(true);
            $table->timestamps();

            $table->foreign('enterprise_id')
                ->references('id')->on('spie_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('coverage_zone_id')
                ->references('id')->on('spie_enterprise_coverage_zones')
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
        Schema::dropIfExists('spie_enterprise_enterprises_has_coverage_zones');
    }
}
