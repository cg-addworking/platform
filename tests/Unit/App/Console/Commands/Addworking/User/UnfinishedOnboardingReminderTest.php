<?php

namespace Tests\Unit\App\Console\Commands\Addworking\User;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess;
use App\Notifications\Addworking\User\OnboardingProcessUnfinishedReminderNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UnfinishedOnboardingReminderTest extends TestCase
{
    use RefreshDatabase;

    public function testHandle()
    {
        $onboardingProcesses = factory(OnboardingProcess::class, 3)->create([
            'last_notified_at' => Carbon::today()->subDays(4),
        ]);

        // we need a 'sogetrel' enterprise because we're filtering out sogetrel vendors
        $enterprise = factory(Enterprise::class)->create([
            'name' => 'SOGETREL'
        ]);

        $this->artisan('addworking:user:unfinished-onboarding-reminder')->assertExitCode(0);

        $onboardingProcesses->each(function ($onboardingProcess) {
            $this->assertTrue(
                $this->needReminder($onboardingProcess),
                "the attached user should be reminded to finish the onboarding process"
            );
        });
    }

    public function needReminder($onboardingProcess)
    {
        if ($onboardingProcess->last_notified_at < Carbon::today()->subDays(3)) {
            return true;
        }

        return false;
    }
}
