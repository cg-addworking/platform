<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingUserOnboardingProcessesTableAddLastNotifiedAtColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_user_onboarding_processes', function (Blueprint $table) {
            $table->timestamp('last_notified_at')->nullable();
        });

        $onboardingProcesses = DB::table('addworking_user_onboarding_processes')->get();

        foreach ($onboardingProcesses as $onboardingProcess) {
            DB::table('addworking_user_onboarding_processes')->whereId($onboardingProcess->id)->update([
                'last_notified_at' => $onboardingProcess->created_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_user_onboarding_processes', function (Blueprint $table) {
            $table->dropColumn('last_notified_at');
        });
    }
}
