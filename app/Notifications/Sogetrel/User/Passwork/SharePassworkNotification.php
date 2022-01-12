<?php

namespace App\Notifications\Sogetrel\User\Passwork;

use App\Models\Sogetrel\User\Passwork;
use App\Repositories\Sogetrel\Enterprise\SogetrelEnterpriseRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Addworking\User\User;

class SharePassworkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * User who shares the passwork
     *
     * @var User
     */
    private $sender;

    /**
     * User who receives the sharing email
     *
     * @var User
     */
    private $reicever;

    /**
     * Shared passwork
     *
     * @var Passwork
     */
    private $passwork;

    /**
     * Comment attached to the mail
     *
     * @var string
     */
    private $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $reicever, Passwork $passwork, string $comment = null)
    {
        $this->sender = $sender;
        $this->reicever = $reicever;
        $this->passwork = $passwork;
        $this->comment = $comment;
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
        return (new MailMessage)
            ->subject('Plateforme Sogetrel AddWorking - Ce profil pourrait vous intéresser !')
            ->markdown('emails.sogetrel.user.passwork.share', $this->toArray());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray()
    {
        $sogetrel = app(SogetrelEnterpriseRepository::class)->getSogetrelEnterprise();

        return [
            'sender'    => $this->sender,
            'reicever'  => $this->reicever,
            'passwork'  => $this->passwork,
            'comment'   => $this->comment,
            'url'       => domain_route($this->passwork->routes->show, $sogetrel)
        ];
    }
}
