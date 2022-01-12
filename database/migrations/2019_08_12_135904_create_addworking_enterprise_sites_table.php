<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingEnterpriseSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_sites', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->string('name');
            $table->string('display_name');
            $table->string('analytic_code')->nullable();
            $table->timestamps();

            $table->primary('id');

            $table
                ->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
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
        Schema::dropIfExists('addworking_enterprise_sites');
    }
}
