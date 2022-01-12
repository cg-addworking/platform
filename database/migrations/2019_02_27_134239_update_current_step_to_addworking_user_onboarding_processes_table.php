<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCurrentStepToAddworkingUserOnboardingProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_user_onboarding_processes', function (Blueprint $table) {
            $table->integer('current_step')->default(0)->comment('starts at zero')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_user_onboarding_processes', function (Blueprint $table) {
            $table->integer('current_step')->default(0)->comment('starts at zero')->change();
        });
    }
}
