<?php

namespace App\Notifications\Addworking\User\Auth;

use App\Models\Addworking\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    private $token;

    /**
     * The user
     *
     * @var User
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param string $token
     *
     * @return void
     */
    public function __construct(User $user, string $token)
    {
        $this->token = $token;
        $this->user = $user;
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
        $url = url(route('password.reset', $this->token));

        return (new MailMessage)
            ->subject('Réinitialisation du mot de passe')
            ->markdown('emails.addworking.user.auth.reset_password', [
                'firstname' => $this->user->firstname,
                'lastname' => $this->user->lastname,
                'url' => $url
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
        return [
            //
        ];
    }
}
