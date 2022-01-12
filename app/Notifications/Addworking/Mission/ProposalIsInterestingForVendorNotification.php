<?php

namespace App\Notifications\Addworking\Mission;

use App\Models\Addworking\Mission\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProposalIsInterestingForVendorNotification extends Notification
{
    use Queueable;

    public $proposal;

    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $date = date_iso_to_date_fr($this->proposal->created_at);

        return (new MailMessage)
            ->subject("Un prestataire est interessé par votre offre {$this->proposal->offer->label}")
            ->markdown('emails.addworking.mission.proposal.vendor_is_interested', [
                'date'     => $date,
                'proposal' => $this->proposal,
                'url'      => domain_route($this->proposal->routes->show, $this->proposal->offer->customer),
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'vendor_name'   => $this->proposal->vendor->name,
            'proposal_date' => date_iso_to_date_fr($this->proposal->created_at),
            'offer_label'   => $this->proposal->offer->label,
            'proposal_url'  => $this->proposal->routes->show,
        ];
    }
}
