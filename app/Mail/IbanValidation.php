<?php

namespace App\Mail;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IbanValidation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Iban
     */
    private $iban;

    /**
     * @var Enterprise
     */
    private $enterprise;

    /**
     * Create a new message instance.
     *
     * @param User       $user
     * @param Iban       $iban
     * @param Enterprise $enterprise
     */
    public function __construct(User $user, Iban $iban)
    {
        $this->user       = $user;
        $this->iban       = $iban;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $routeParams = [
            'enterprise' => $this->iban->enterprise,
            'iban'       => $this->iban,
            'token'      => $this->iban->validation_token,
        ];

        return $this->subject(__('emails.iban.validation.title'))
            ->markdown('emails.iban.validation')
            ->with([
                'user'        => $this->user,
                'iban'        => $this->iban,
                'url_confirm' => domain_route(route('enterprise.iban.confirm', $routeParams), $this->iban->enterprise),
                'url_cancel'  => domain_route(route('enterprise.iban.cancel', $routeParams), $this->iban->enterprise),
            ]);
    }
}
