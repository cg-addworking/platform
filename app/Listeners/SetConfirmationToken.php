<?php

namespace App\Listeners;

use App\Contracts\Events\UserAwareEvent;
use Illuminate\Support\Str;

class SetConfirmationToken
{
    public function handle(UserAwareEvent $event)
    {
        $event->user->setConfirmationToken(Str::random(60));
        $event->user->save();
    }
}
