<?php

namespace App\Notifications\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class DocumentOutdatedNotification extends Notification
{
    use Queueable;

    public $enterprise;
    public $documents;

    public function __construct(Enterprise $enterprise, Collection $documents)
    {
        $this->enterprise = $enterprise;
        $this->documents  = $documents;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('[ATTENTION] Vous avez des documents expirés')
            ->markdown('emails.addworking.enterprise.document.outdated', [
                'enterprise' => $this->enterprise,
                'documents'  => $this->documents
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'enterprise' => $this->enterprise->name,
            'documents'  => $this->documents->count(),
        ];
    }
}
