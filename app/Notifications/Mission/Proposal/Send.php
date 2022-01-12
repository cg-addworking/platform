<?php

namespace App\Notifications\Mission\Proposal;

use App\Models\Addworking\Mission\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Send extends Notification implements ShouldQueue
{
    use Queueable;

    protected $proposal;

    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle proposition de mission')
            ->markdown('emails.mission.proposal.send', [
                'proposal' => $this->proposal,
                'url' => domain_route($this->proposal->routes->show, $this->proposal->offer->customer),
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
