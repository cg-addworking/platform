<?php

namespace Components\Mission\Offer\Application\Notifications;

use Components\Mission\Offer\Application\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeclineNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $offer;
    
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Votre réponse à une offre {$this->offer->getCustomer()} n’a pas été retenue")
            ->markdown('offer::offer.emails.decline_notification', [
                'offer' => $this->offer,
                'url' => route('sector.offer.show', $this->offer)
            ]);
    }
}
