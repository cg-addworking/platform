<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingUserOnboardingProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_user_onboarding_processes', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id');
            $table->uuid('enterprise_id');
            $table->integer('current_step')->default(0)->comment('starts at zero');
            $table->boolean('complete')->default(false);
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->primary('id');
            $table->timestamps();

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('addworking_user_users')
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
        Schema::dropIfExists('addworking_user_onboarding_processes');
    }
}
