<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileMissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_mission', function (Blueprint $table) {
            $table->uuid('file_id');
            $table->uuid('mission_id');
            $table->string('name');
            $table->timestamps();
            $table->primary(['file_id', 'mission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_mission');
    }
}
