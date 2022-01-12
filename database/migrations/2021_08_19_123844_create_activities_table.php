<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('short_id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('domaine')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('sector_id')->nullable();
            $table->uuid('country_id');

            $table->primary('id');

            $table->foreign('sector_id')
                ->references('id')->on('addworking_enterprise_sectors')
                ->onDelete('SET NULL');
            
            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
