<?php

namespace App\Notifications\Addworking\User;

use App\Models\Addworking\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountAutomaticallyCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $password;

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
            ->greeting('Bienvenue sur Addworking !')
            ->line("Votre nouveau compte Addworking est enfin prêt !")
            ->line("Votre identifiant est: {$this->user->email} ")
            ->line("Votre mot de passe temporaire est: {$this->password}")
            ->action('Connexion', route('login'))
            ->line("Merci d'utiliser notre application");
    }

    public function toArray($notifiable)
    {
        return [
            'user' => $this->user->email,
            'password' => str_repeat('*', strlen($this->password)),
        ];
    }
}
