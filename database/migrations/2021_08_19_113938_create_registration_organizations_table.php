<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_organizations', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('short_id');
            $table->uuid('country_id');
            $table->string('name');
            $table->string('acronym');
            $table->string('location')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
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
        Schema::dropIfExists('registration_organizations');
    }
}
