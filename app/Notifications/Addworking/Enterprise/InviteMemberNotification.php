<?php

namespace App\Notifications\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Invitation;
use App\Support\Token\InvitationTokenManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteMemberNotification extends Notification implements ShouldQueue
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
                ->markdown('emails.addworking.enterprise.member.invitation', [
                    'invitation' => $this->invitation,
                    'url_accept' => route('addworking.enterprise.invitation.response', [
                        'token' => $this->manager->encode($this->prepareTokenData(['is_accepted' => true]))
                    ]),
                    'url_refuse' => route('addworking.enterprise.invitation.response', [
                        'token' => $this->manager->encode($this->prepareTokenData(['is_accepted' => false]))
                    ]),
                ])
                ->from('support@addworking.com')
                ->subject(
                    "Vous avez été invité à rejoindre l'entreprise '{$this->invitation->host->name}' sur AddWorking"
                )
        ;
    }

    public function prepareTokenData(array $extraData = [])
    {
        return [
            'invitation_id' => $this->invitation->id,
            'host_id' => $this->invitation->host->id,
            'email' => $this->invitation->contact,
            'member' => $this->invitation->additional_data,
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
