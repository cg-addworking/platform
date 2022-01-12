<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterpriseMembershipRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_membership_requests', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->uuid('user_id');
            $table->uuid('role_id')->nullable();
            $table->string('status')->default('pending');
            $table->string('validation_token');
            $table->timestamps();
            $table->primary('id');
            $table->unique('validation_token');

            $table->unique(['enterprise_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_membership_requests');
    }
}
