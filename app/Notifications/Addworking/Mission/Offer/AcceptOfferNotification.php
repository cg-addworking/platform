<?php

namespace App\Notifications\Addworking\Mission\Offer;

use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptOfferNotification extends Notification
{
    use Queueable;

    protected $offer;
    protected $proposal;
    
    public function __construct(Offer $offer, Proposal $proposal)
    {
        $this->offer = $offer;
        $this->proposal = $proposal;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Votre réponse à une offre {$this->offer->customer} a été retenue")
            ->markdown('emails.addworking.mission.offer.accept-offer', [
                'offer' => $this->offer,
                'proposal' => $this->proposal,
                'url' => domain_route(route('mission.proposal.show', $this->proposal), $this->offer->customer)
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'label' => $this->offer->label,
        ];
    }
}
