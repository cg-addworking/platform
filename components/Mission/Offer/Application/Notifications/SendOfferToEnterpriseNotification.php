<?php

namespace Components\Mission\Offer\Application\Notifications;

use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOfferToEnterpriseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $offer;

    public function __construct(OfferEntityInterface $offer)
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
            ->subject("Nouvelle proposition de mission")
            ->markdown('offer::offer.emails.send_offer_to_enterprise', [
                'url' => route('sector.offer.show', $this->offer),
                'offer' => $this->offer,
            ]);
    }
}
