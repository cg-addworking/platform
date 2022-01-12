<?php

namespace App\Notifications\Addworking\Mission;

use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestCloseOfferNotification extends Notification
{
    use Queueable;

    protected $sender;
    protected $offer;

    public function __construct(User $sender, Offer $offer)
    {
        $this->sender = $sender;
        $this->offer  = $offer;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Vous avez une offre de mission à clôturer")
            ->markdown('emails.addworking.mission.offer.request_close_offer', [
                'sender' => $this->sender->name,
                'offer'  => $this->offer,
                'url'    => domain_route(route('mission.offer.show', $this->offer), $this->offer->customer)
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'sender' => $this->sender->name,
            'offer' => $this->offer,
        ];
    }
}
