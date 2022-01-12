<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSogetrelUserPassworkSavedSearchesScheduledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_user_passwork_saved_searches_scheduled', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('passwork_saved_search_id');
            $table->string('email');
            $table->integer('frequency');
            $table->primary('id');
            $table
                ->foreign('passwork_saved_search_id')
                ->references('id')
                ->on('sogetrel_user_passwork_saved_searches')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sogetrel_user_passwork_saved_searches_scheduled');
    }
}
