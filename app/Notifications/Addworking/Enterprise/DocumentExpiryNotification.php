<?php

namespace App\Notifications\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class DocumentExpiryNotification extends Notification
{
    use Queueable;

    public $enterprise;
    public $days;
    public $documents;

    public function __construct(Enterprise $enterprise, int $days, Collection $documents)
    {
        $this->enterprise = $enterprise;
        $this->days       = $days;
        $this->documents  = $documents;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if (count($this->documents) == 1) {
            $subject = "Pensez à actualiser votre {$this->documents->first()}";
        } else {
            $subject = "Pensez à actualiser vos documents";
        }

        return (new MailMessage)
            ->subject($subject)
            ->markdown('emails.addworking.enterprise.document.expires_soon', [
                'enterprise' => $this->enterprise,
                'documents'  => $this->documents,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'enterprise' => $this->enterprise->name,
            'days'       => $this->days,
            'documents'  => count($this->documents),
        ];
    }
}
