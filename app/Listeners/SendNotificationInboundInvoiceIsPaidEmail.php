<?php

namespace App\Listeners;

use App\Contracts\Billing\Invoice;
use App\Events\InboundInvoiceSaved;
use App\Mail\NotificationInboundInvoiceIsPaid;
use Illuminate\Support\Facades\Mail;

class SendNotificationInboundInvoiceIsPaidEmail
{
    /**
     * Handle the event.
     *
     * @param  InboundInvoiceSaved  $event
     * @return void
     */
    public function handle(InboundInvoiceSaved $event)
    {
        $inboundInvoice = $event->invoice;

        if (!$inboundInvoice->exists) {
            return;
        }

        if ($inboundInvoice->status != Invoice::STATUS_PAID) {
            return;
        }

        $originalInboundInvoice = $event->invoice->getOriginal();
        if (!isset($originalInboundInvoice['status']) || $originalInboundInvoice['status'] == Invoice::STATUS_PAID) {
            return;
        }

        $owners = $inboundInvoice->enterprise->legalRepresentatives;
        foreach ($owners as $owner) {
            Mail::to($owner->email)->send(new NotificationInboundInvoiceIsPaid($inboundInvoice, $owner));
        }
    }
}
