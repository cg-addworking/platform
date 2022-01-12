<?php

namespace  App\Notifications\Addworking\Billing;

use App\Models\Addworking\User\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InboundInvoiceCsvExportNotification extends Notification
{
    protected $url;
    protected $user;

    public function __construct(string $url, User $user)
    {
        $this->user = $user;
        $this->url  = $url;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Export des factures prestataires pour ".$this->user->enterprise->name)
            ->markdown('emails.addworking.billing.inbound_invoice.export', [
                'url' => domain_route(
                    $this->url,
                    $this->user->enterprise
                ),
            ]);
    }
}
