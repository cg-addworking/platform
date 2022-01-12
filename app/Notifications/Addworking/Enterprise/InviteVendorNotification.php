<?php

namespace App\Notifications\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Invitation;
use App\Support\Token\InvitationTokenManager;
use Components\Common\Common\Domain\Interfaces\Entities\CountryEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteVendorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invitation;
    protected $manager;

    public function __construct(Invitation $invitation, InvitationTokenManager $manager)
    {
        $this->invitation = $invitation;
        $this->manager = $manager;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $local = $this->invitation->host->getCountry() == CountryEntityInterface::CODE_BELGIUM
            ? CountryEntityInterface::CODE_FRANCE
            : $this->invitation->host->country;

        return (new MailMessage)
            ->markdown('emails.addworking.enterprise.vendor.invitation', [
                'invitation' => $this->invitation,
                'url_accept' => domain_route(
                    route(
                        'addworking.enterprise.invitation.response',
                        [
                            'token' => $this->manager->encode($this->prepareTokenData(['is_accepted' => true])),
                            'locale' => $local,
                        ]
                    ),
                    $this->invitation->host
                ),
                'url_refuse' => domain_route(
                    route(
                        'addworking.enterprise.invitation.response',
                        [
                            'token' => $this->manager->encode($this->prepareTokenData(['is_accepted' => false])),
                            'locale' => $local,
                        ]
                    ),
                    $this->invitation->host
                ),
                'local' => $local,
            ])
            ->from('support@addworking.com')
            ->subject(
                __(
                    'addworking.enterprise.vendor.invitation.notification.title',
                    ['client_name' => $this->invitation->host->name],
                    $local
                )
            );
    }

    public function prepareTokenData(array $extraData = [])
    {
        return [
            'invitation_id' => $this->invitation->id,
            'host_id' => $this->invitation->host->id,
            'email' => $this->invitation->contact,
        ] + $extraData;
    }

    public function toArray($notifiable)
    {
        return [
            'invitation' => $this->invitation->id,
            'email' => $this->invitation->email,
            'type' => $this->invitation->type
        ];
    }
}
