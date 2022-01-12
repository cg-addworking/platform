<?php

namespace App\Notifications\Sogetrel\User\Passwork;

use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork;
use App\Repositories\Sogetrel\Enterprise\SogetrelEnterpriseRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorEditNotification extends Notification
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

        return (new MailMessage)
            ->subject("Mise à jour de votre profil AddWorking")
            ->markdown('emails.sogetrel.user.passwork.vendor_edit', [
                'passwork'    => $this->passwork,
                'url'         => domain_route($this->passwork->routes->edit, $sogetrel)
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'passwork_url' => $this->passwork->routes->edit,
        ];
    }
}
