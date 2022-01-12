<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSogetrelUserPassworkLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_user_passwork_logs', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('passwork_id');
            $table->foreign('passwork_id')->references('id')->on('sogetrel_user_passworks')->onDelete('cascade');
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('addworking_user_users')->onDelete('set null');
            $table->text('message')->nullable();
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
        Schema::dropIfExists("sogetrel_user_passwork_logs");
    }
}
