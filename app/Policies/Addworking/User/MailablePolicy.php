<?php

namespace App\Policies\Addworking\User;

use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Mail\Mailable;

class MailablePolicy
{
    use HandlesAuthorization;

    public function receive(User $user, Mailable $mail)
    {
        if (! $user->notificationPreferences->email_enabled) {
            return false;
        }

        if ($mail instanceof \App\Mail\IbanValidation) {
            return $user->notificationPreferences->iban_validation;
        }

        if ($mail instanceof \App\Mail\MissionTrackingCreated) {
            return $user->notificationPreferences->mission_tracking_created;
        }

        return true;
    }
}
