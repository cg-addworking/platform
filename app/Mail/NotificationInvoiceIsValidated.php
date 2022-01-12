<?php

namespace App\Mail;

use App\Models\Addworking\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationInvoiceIsValidated extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Vous avez une nouvelle facture")
            ->markdown('emails.user.new_invoice_notification')
            ->with([
                'user' => $this->user
            ]);
    }
}
