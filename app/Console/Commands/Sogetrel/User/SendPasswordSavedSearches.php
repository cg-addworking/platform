<?php

namespace App\Console\Commands\Sogetrel\User;

use App\Mail\PassworksSearchNotification;
use App\Models\Sogetrel\User\Passwork;
use App\Models\Sogetrel\User\PassworkSavedSearchSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendPasswordSavedSearches extends Command
{
    protected $signature = 'sogetrel:user:send-passwork-saved-search';

    protected $description = 'Send the mails listing the result of search of the passworks';

    public function handle()
    {
        foreach (PassworkSavedSearchSchedule::with('passworkSavedSearch')->cursor() as $schedule) {
            if (! $schedule->shouldRun()) {
                continue;
            }

            $request   = new Request(['search' => $schedule->passworkSavedSearch->search]);
            $passworks = Passwork::search($request)->latest()->get();

            Mail::to($schedule->email)->send(new PassworksSearchNotification($passworks, $schedule));

            $schedule->update(['last_sent_at' => Carbon::now()]);
        }
    }
}
