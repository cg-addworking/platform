<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableAddworkingUserCustomerCreatedUsers extends Migration
{
    public function up()
    {
        Schema::dropIfExists('addworking_user_customer_created_users');
    }

    public function down()
    {
        Schema::create('addworking_user_customer_created_users', function (Blueprint $table) {
            $table->uuid('enterprise_id');
            $table->uuid('user_id');
            $table->string('status')->default("pending");
            $table->timestamps();
            $table->primary(['user_id', 'enterprise_id']);

            $table->foreign('user_id')->references('id')->on('addworking_user_users')->onDelete('cascade');
            $table->foreign('enterprise_id')->references('id')->on('addworking_enterprise_enterprises')->onDelete('cascade');
        });
    }
}
