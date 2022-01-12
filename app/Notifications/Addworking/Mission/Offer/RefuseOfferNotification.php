<?php

namespace App\Notifications\Addworking\Mission\Offer;

use App\Models\Addworking\Mission\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefuseOfferNotification extends Notification implements ShouldQueue
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
            ->subject("Votre réponse à une offre {$this->offer->customer} n’a pas été retenue")
            ->markdown('emails.addworking.mission.offer.refuse-offer', [
                'offer' => $this->offer,
                'url' => domain_route(route('mission.offer.show', $this->offer), $this->offer->customer)
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'label' => $this->offer->label,
        ];
    }
}
