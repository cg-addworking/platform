<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('address');
            $table->string('additionnal_address')->nullable();
            $table->string('zipcode');
            $table->string('town');
            $table->string('country', 2)->comment('ISO 3166-1 alpha-2');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('address_enterprise', function (Blueprint $table) {
            $table->uuid('address_id');
            $table->uuid('enterprise_id');
            $table->primary(['address_id', 'enterprise_id']);

            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
        });

        Schema::create('address_user', function (Blueprint $table) {
            $table->uuid('address_id');
            $table->uuid('user_id');
            $table->primary(['address_id', 'user_id']);

            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_user');
        Schema::dropIfExists('address_enterprise');
        Schema::dropIfExists('addresses');
    }
}
