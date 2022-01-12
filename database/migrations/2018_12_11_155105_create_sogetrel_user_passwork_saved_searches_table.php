<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSogetrelUserPassworkSavedSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_user_passwork_saved_searches', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id');
            $table->json('search');
            $table->primary('id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sogetrel_user_passwork_saved_searches');
    }
}
