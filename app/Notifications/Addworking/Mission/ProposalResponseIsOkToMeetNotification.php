<?php

namespace App\Notifications\Addworking\Mission;

use App\Models\Addworking\Mission\ProposalResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProposalResponseIsOkToMeetNotification extends Notification
{
    use Queueable;

    protected $response;

    public function __construct(ProposalResponse $response)
    {
        $this->response = $response;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $date = date_iso_to_date_fr($this->response->proposal->offer->created_at);

        return (new MailMessage)
            ->subject("Nouvelle réponse à votre offre de mission du {$date}")
            ->markdown('emails.addworking.mission.proposal_response.ok_to_meet', [
                'date'     => $date,
                'response' => $this->response,
                'url'      => domain_route($this->response->routes->show, $this->response->proposal->offer->customer)
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'referent_name' => $this->response->proposal->offer->referent->name,
            'vendor_name'   => $this->response->proposal->vendor->name,
            'offer_date'    => date_iso_to_date_fr($this->response->proposal->offer->created_at),
            'offer_label'   => $this->response->proposal->offer->label,
            'response_url'  => $this->response->routes->show,
        ];
    }
}
