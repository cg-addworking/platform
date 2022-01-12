<?php

namespace App\Notifications\Mission\Proposal;

use App\Models\Addworking\Mission\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Assign extends Notification
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
            ->subject('Proposition de mission assignée')
            ->markdown('emails.mission.proposal.assign', [
                'proposal' => $this->proposal,
                'url'      => domain_route($this->proposal->routes->show, $this->proposal->offer->customer),
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
