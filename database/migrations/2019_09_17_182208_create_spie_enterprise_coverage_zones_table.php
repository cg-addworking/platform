<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpieEnterpriseCoverageZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spie_enterprise_coverage_zones', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('department_id')->nullable();
            $table->string('code')->unique();
            $table->string('label')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('department_id')
                ->references('id')->on('addworking_common_departments')
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
        Schema::dropIfExists('spie_enterprise_coverage_zones');
    }
}
