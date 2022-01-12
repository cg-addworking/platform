<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id');
            $table->text('path')->unique();
            $table->string('mime_type')->default('application/octet-stream');
            $table->integer('size')->default(0)->comment('bytes');
            $table->binary('content')->nullable();
            $table->string('md5', 32)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('enterprise_file', function (Blueprint $table) {
            $table->uuid('enterprise_id');
            $table->uuid('file_id');
            $table->string('type');
            $table->date('date')->nullable();
            $table->string('key')->nullable();
            $table->string('status')->default('pending_validation');
            $table->timestamps();
            $table->primary(['file_id', 'enterprise_id']);

            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_file');
        Schema::dropIfExists('files');
    }
}
