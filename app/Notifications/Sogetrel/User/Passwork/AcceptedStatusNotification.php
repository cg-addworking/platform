<?php

namespace App\Notifications\Sogetrel\User\Passwork;

use App\Models\Sogetrel\User\Passwork;
use App\Repositories\Sogetrel\Enterprise\SogetrelEnterpriseRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AcceptedStatusNotification extends Notification
{
    use Queueable;

    protected $passwork;

    public function __construct(Passwork $passwork)
    {
        $this->passwork = $passwork;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $sogetrel = app(SogetrelEnterpriseRepository::class)->getSogetrelEnterprise();
        $vendor_name = $this->passwork->user->name ?? '';

        return (new MailMessage)
            ->subject("Le passwork {$vendor_name} est passé au statut : accepté pour contractualisation")
            ->markdown('emails.sogetrel.user.passwork.accepted_status', [
                'passwork'    => $this->passwork,
                'vendor_name' => $vendor_name,
                'url'         => domain_route($this->passwork->routes->show, $sogetrel)
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'vendor_name'  => $this->passwork->user->name ?? '',
            'passwork_url' => $this->passwork->routes->show,
        ];
    }
}
