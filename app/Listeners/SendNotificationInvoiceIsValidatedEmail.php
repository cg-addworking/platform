<?php

namespace App\Listeners;

use App\Events\InvoiceIsValidated;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationInvoiceIsValidated;

class SendNotificationInvoiceIsValidatedEmail
{
    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle(InvoiceIsValidated $event)
    {
        $users = $event->invoice->enterprise->legalRepresentatives;

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotificationInvoiceIsValidated($user));
        }
    }
}
