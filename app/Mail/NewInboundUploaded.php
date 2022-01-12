<?php

namespace App\Mail;

use App\Models\Addworking\Billing\InboundInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewInboundUploaded extends Mailable
{
    use Queueable, SerializesModels;

    protected $inbound_invoice;

    public function __construct(InboundInvoice $inbound_invoice)
    {
        $this->inbound_invoice = $inbound_invoice;
    }

    public function build()
    {
        return $this->subject("Nouvelle facture prestataire {$this->inbound_invoice->enterprise->name}")
            ->markdown('emails.addworking.billing.inbound_invoice.new_inbound_uploaded')
            ->with([
                'inbound_invoice' => $this->inbound_invoice,
                'url' => domain_route($this->inbound_invoice->routes->show, $this->inbound_invoice->customer),
            ]);
    }
}
