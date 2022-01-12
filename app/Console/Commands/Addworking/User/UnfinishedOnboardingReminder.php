<?php

namespace App\Console\Commands\Addworking\User;

use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Sogetrel\User\Passwork;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UnfinishedOnboardingReminder extends Command
{
    protected $signature = 'addworking:user:unfinished-onboarding-reminder';

    protected $description = 'Send a reminder to vendors who have unfinished onboarding process';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $onboarding_processes = OnboardingProcess::incomplete()
            ->where(function ($query) {
                return $query->where('last_notified_at', '<=', Carbon::now()->subDays(3))
                    ->orWhereNull('last_notified_at');
            })
            ->get()
            ->filter(function ($item) {
                return ! ($item->user->sogetrelPasswork->exists
                    && $item->user->sogetrelPasswork->status !== Passwork::STATUS_ACCEPTED);
            })
            ->filter(function ($item) {
                return $item->user->created_at->toDateString() >= Carbon::now()->subMonth()->toDateString();
            });

        foreach ($onboarding_processes as $op) {
            $op->sendReminder();
        }
    }
}
