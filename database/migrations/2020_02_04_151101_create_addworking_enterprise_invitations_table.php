<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_invitations', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('host_id');
            $table->uuid('guest_id')->nullable();
            $table->uuid('guest_enterprise_id')->nullable();
            $table->json('additional_data')->nullable();
            $table->string('contact');
            $table->string('status')->default('pending');
            $table->string('type');
            $table->timestamp('valid_until');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('host_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('guest_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('cascade');

            $table->foreign('guest_enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_enterprise_invitations');
    }
}
