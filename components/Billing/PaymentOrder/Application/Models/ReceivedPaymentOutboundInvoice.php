<?php
namespace Components\Billing\PaymentOrder\Application\Models;

use App\Helpers\HasUuid;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Domain\Classes\ReceivedPaymentOutboundInvoiceInterface;
use Illuminate\Database\Eloquent\Model;

class ReceivedPaymentOutboundInvoice extends Model implements ReceivedPaymentOutboundInvoiceInterface
{
    use HasUuid;

    protected $table = "addworking_billing_received_payments_outbound_invoices";

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function outboundInvoice()
    {
        return $this->belongsTo(OutboundInvoice::class)->withDefault();
    }

    public function receivedPayment()
    {
        return $this->belongsTo(ReceivedPayment::class)->withDefault();
    }

    public function setOutboundInvoice($outbound_invoice)
    {
        $this->outboundInvoice()->associate($outbound_invoice);
    }

    public function setReceivedPayment($received_payment)
    {
        $this->receivedPayment()->associate($received_payment);
    }
}
