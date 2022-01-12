<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InboundInvoiceReconciliation extends Mailable
{
    use Queueable, SerializesModels;

    protected $inbound_invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inbound_invoice)
    {
        $this->inbound_invoice = $inbound_invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
            ->subject("Réconciliation de facture")
            ->markdown('emails.addworking.billing.inbound_invoice.inbound_invoice_reconciliation')
            ->with([
                'inbound_invoice' => $this->inbound_invoice,
                'enterprise' => $this->inbound_invoice->enterprise,
                'url' => domain_route(
                    $this->inbound_invoice->routes->show,
                    $this->inbound_invoice->enterprise,
                    $this->inbound_invoice
                )
            ]);
    }
}
