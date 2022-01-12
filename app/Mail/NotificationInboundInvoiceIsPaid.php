<?php
namespace App\Mail;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationInboundInvoiceIsPaid extends Mailable
{
    use Queueable, SerializesModels;

    private $inboundInvoice;
    private $user;

    public function __construct(InboundInvoice $inboundInvoice, User $user)
    {
        $this->inboundInvoice = $inboundInvoice;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject("Votre facture {$this->inboundInvoice->number} a été payée !")
            ->markdown('emails.user.inbound_invoice_paid')
            ->with([
                'inboundInvoice' => $this->inboundInvoice,
                'user' => $this->user,
                'url' => domain_route($this->inboundInvoice->routes->show, $this->inboundInvoice->customer)
            ]);
    }
}
