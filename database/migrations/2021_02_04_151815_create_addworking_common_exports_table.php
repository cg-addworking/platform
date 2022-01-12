<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingCommonExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_common_exports', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id');
            $table->uuid('file_id')->nullable();

            $table->string('name');
            $table->string('status');
            $table->json('filters')->nullable();
            $table->text('error_message')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('addworking_user_users')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('addworking_common_files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_common_exports');
    }
}
