<?php

namespace App\Mail;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorAttachedToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $enterprise;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Enterprise $customer)
    {
        $this->user = $user;
        $this->enterprise = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("L'entreprise {$this->enterprise->name} souhaite vous ajouter en tant que prestataire")
            ->markdown('emails.user.vendor_attached_to_customer')
            ->with([
                'user'                  => $this->user,
                'customer'              => $this->enterprise,
                'url_accept_invitation' => domain_route(
                    route('vendor-accept-invitation', ['user' => $this->user->id, 'customer' => $this->enterprise->id]),
                    $this->enterprise
                ),
                'url_refuse_invitation' => domain_route(
                    route('vendor-refuse-invitation', ['user' => $this->user->id, 'customer' => $this->enterprise->id]),
                    $this->enterprise
                ),
            ]);
    }
}
