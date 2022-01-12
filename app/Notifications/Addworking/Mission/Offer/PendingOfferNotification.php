<?php

namespace App\Notifications\Addworking\Mission\Offer;

use App\Models\Addworking\Mission\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendingOfferNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public $offer;

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
            ->subject("Une offre de mission {$this->offer->customer} a été clôturée")
            ->markdown('emails.addworking.mission.offer.pending-offer', [
                'offer' => $this->offer,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'label' => $this->offer->label,
        ];
    }
}
