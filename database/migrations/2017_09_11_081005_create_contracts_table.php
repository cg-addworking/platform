<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id')->nullable();
            $table->uuid('enterprise_id')->nullable();
            $table->uuid('file_id')->nullable();

            $table->integer('number')->unique();

            $table->string('status')->default('draft');
            $table->string('type');
            $table->string('version');
            $table->string('name');

            $table->string('signinghub_package_id')->nullable();
            $table->string('signinghub_document_id')->nullable()->unique();

            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('set null');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
