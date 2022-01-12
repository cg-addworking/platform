<?php

namespace App\Notifications\Addworking\User;

use App\Models\Addworking\User\OnboardingProcess;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OnboardingProcessUnfinishedReminderNotification extends Notification
{
    use Queueable;

    public $onboardingProcess;

    public function __construct(OnboardingProcess $onboardingProcess)
    {
        $this->onboardingProcess = $onboardingProcess;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        switch ($this->onboardingProcess->enterprise->name) {
            case 'SOGETREL':
                $url = 'https://sogetrel.addworking.com';
                break;

            case 'EDENRED':
                $url = 'https://edenred.addworking.com';
                break;

            case 'EVERIAL':
                $url = 'https://everial.addworking.com';
                break;

            case 'ADDWORKING':
                $url = 'https://app.addworking.com';
                break;

            default:
                $url = 'https://app.addworking.com';
        }

        return (new MailMessage)
            ->subject("Votre enregistrement sur AddWorking")
            ->markdown('emails.addworking.user.onboarding_process.unfinished_reminder', [
                'user' => $this->onboardingProcess->user,
                'url' => $url,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        switch ($this->onboardingProcess->enterprise->name) {
            case 'SOGETREL':
                $url = 'https://sogetrel.addworking.com';
                break;

            case 'EDENRED':
                $url = 'https://edenred.addworking.com';
                break;

            case 'EVERIAL':
                $url = 'https://everial.addworking.com';
                break;

            case 'ADDWORKING':
                $url = 'https://app.addworking.com';
                break;

            default:
                $url = 'https://app.addworking.com';
        }
        return [
            'user_name' => $this->onboardingProcess->user->name,
            'url'  => $url,
        ];
    }
}
