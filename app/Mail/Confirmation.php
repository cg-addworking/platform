<?php

namespace App\Mail;

use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\AddworkingEnterpriseRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Confirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $addworking = app(AddworkingEnterpriseRepository::class)->getAddworkingEnterprise();
        $this->url = domain_route(route('confirmation', ['token' => $user->getConfirmationToken()]), $addworking);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__('messages.confirmation.mail_title'))
            ->markdown('emails.user.confirmation')
            ->with(['user' => $this->user, 'url' => $this->url]);
    }
}
