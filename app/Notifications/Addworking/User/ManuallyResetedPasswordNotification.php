<?php

namespace App\Notifications\Addworking\User;

use App\Models\Addworking\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ManuallyResetedPasswordNotification extends Notification
{
    use Queueable;

    public $user;

    public $password;

    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Votre nouveau mot de passe AddWorking !')
            ->line("Votre mot de passe AddWorkng à été réinitialisé")
            ->line("Votre identifiant est toujours: {$this->user->email} ")
            ->line("Votre nouveau mot de passe est: {$this->password}")
            ->action('Connexion', route('login'))
            ->line("Merci d'utiliser notre application");
    }

    public function toArray($notifiable)
    {
        return [
            'email' => $this->user->email,
            'password' => str_repeat('*', strlen($this->password)),
        ];
    }
}
