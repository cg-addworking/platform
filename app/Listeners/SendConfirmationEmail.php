<?php

namespace App\Listeners;

use App\Contracts\Events\UserAwareEvent;
use App\Mail\Confirmation;
use Illuminate\Support\Facades\Mail;

class SendConfirmationEmail
{
    public function handle(UserAwareEvent $event)
    {
        Mail::to($event->user->email)->send(new Confirmation($event->user));
    }
}
