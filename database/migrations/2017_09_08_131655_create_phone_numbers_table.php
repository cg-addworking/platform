<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('number')->unique();
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('enterprise_phone_number', function (Blueprint $table) {
            $table->uuid('enterprise_id');
            $table->uuid('phone_number_id');
            $table->string('note')->nullable();
            $table->primary(['enterprise_id', 'phone_number_id']);

            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('phone_number_id')->references('id')->on('phone_numbers')->onDelete('cascade');
        });

        Schema::create('phone_number_user', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('phone_number_id');
            $table->string('note')->nullable();
            $table->primary(['user_id', 'phone_number_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('phone_number_id')->references('id')->on('phone_numbers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_phone_number');
        Schema::dropIfExists('phone_number_user');
        Schema::dropIfExists('phone_numbers');
    }
}
