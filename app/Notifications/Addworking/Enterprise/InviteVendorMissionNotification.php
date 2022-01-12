<?php

namespace App\Notifications\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Invitation;
use App\Support\Token\InvitationTokenManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteVendorMissionNotification extends Notification implements ShouldQueue
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
        return (new MailMessage)
            ->markdown('emails.addworking.mission.proposal.invitation', [
                'invitation' => $this->invitation,
                'url_accept' => domain_route(
                    route(
                        'addworking.enterprise.invitation.response',
                        ['token' => $this->manager->encode($this->prepareTokenData(['is_accepted' => true]))]
                    ),
                    $this->invitation->host
                ),
                'url_refuse' => domain_route(
                    route(
                        'addworking.enterprise.invitation.response',
                        ['token' => $this->manager->encode($this->prepareTokenData(['is_accepted' => false]))]
                    ),
                    $this->invitation->host
                ),
            ])
            ->from('support@addworking.com')
            ->subject(
                "{$this->invitation->host->name} diffuse sur AddWorking des offres susceptibles de vous intéresser"
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
