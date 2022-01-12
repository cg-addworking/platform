<?php

namespace Components\Enterprise\ActivityReport\Application\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use SplFileObject;

class SendActivityReportsNotification extends Notification
{
    use Queueable;

    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(
                "Rapport d’activité - " . Carbon::now()->format('F') . " " . Carbon::now()->format('Y')
            )->markdown('activity_report::emails.report')->attach($this->path) ;
    }
}
