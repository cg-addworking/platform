<?php

namespace Components\Mission\Offer\Application\Notifications;

use Components\Mission\Offer\Domain\Interfaces\Entities\ResponseEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCreateResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $response;

    public function __construct(ResponseEntityInterface $response)
    {
        $this->response = $response;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Nouvelle réponse à votre offre de mission")
            ->markdown('offer::response.emails.create_notification', [
                'url' => route('sector.response.show', [$this->response->getOffer(), $this->response]),
                'response' => $this->response,
            ]);
    }
}
