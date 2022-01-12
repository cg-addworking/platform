<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillingReminder extends Mailable
{
    use Queueable, SerializesModels;

    protected $enterprise;
    protected $user;
    protected $month;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($enterprise, $user, $month)
    {
        $this->enterprise = $enterprise;
        $this->user       = $user;
        $this->month      = $month;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
            ->subject(sprintf(
                'Rappel: votre facture de %s pour le client %s',
                $this->month,
                $this->enterprise->name
            ))
            ->markdown('emails.user.billing_reminder')
            ->with([
                'user'       => $this->user,
                'enterprise' => $this->enterprise,
                'month'      => month_fr(substr($this->month, 0, 2)),
            ]);
    }
}
