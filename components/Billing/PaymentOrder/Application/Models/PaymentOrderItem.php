<?php
namespace Components\Billing\PaymentOrder\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Iban;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderItemInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentOrderItem extends Model implements PaymentOrderItemInterface
{
    use HasUuid,
        SoftDeletes;

    protected $table = "addworking_billing_payment_order_items";

    protected $fillable = [
        'number',
        'enterprise_name',
        'enterprise_iban',
        'enterprise_bic',
        'amount'
    ];

    protected $casts = [
        'number' => 'integer',
        'amount' => 'float'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function paymentOrder()
    {
        return $this->belongsTo(PaymentOrder::class)->withDefault();
    }

    public function inboundInvoice()
    {
        return $this->belongsTo(InboundInvoice::class)->withDefault();
    }

    public function iban()
    {
        return $this->belongsTo(Iban::class)->withDefault();
    }

    public function outboundInvoice()
    {
        return $this->belongsTo(OutboundInvoice::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Setters & Getters
    // ------------------------------------------------------------------------

    public function setPaymentOrder($payment_order)
    {
        $this->paymentOrder()->associate($payment_order);
    }

    public function setInboundInvoice($inbound_invoice)
    {
        $this->inboundInvoice()->associate($inbound_invoice);
    }

    public function setOutboundInvoice($outbound_invoice)
    {
        $this->outboundInvoice()->associate($outbound_invoice);
    }

    public function setIban($iban)
    {
        $this->iban()->associate($iban);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setEnterpriseName(string $name)
    {
        $this->enterprise_name = $name;
    }

    public function setEnterpriseIban(string $iban)
    {
        $this->enterprise_iban = $iban;
    }

    public function setEnterpriseBic(string $bic)
    {
        $this->enterprise_bic = $bic;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    public function getPaymentOrder()
    {
        return $this->paymentOrder()->first();
    }

    public function getInboundInvoice()
    {
        return $this->inboundInvoice()->first();
    }

    public function getOutboundInvoice()
    {
        return $this->outboundInvoice()->first();
    }

    public function getIban()
    {
        return $this->iban()->first();
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getEnterpriseName()
    {
        return $this->enterprise_name;
    }

    public function getEnterpriseIban()
    {
        return $this->enterprise_iban;
    }

    public function getEnterpriseBic()
    {
        return $this->enterprise_bic;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getReference(): string
    {
        $item_number = str_pad($this->getNumber(), 6, "0", STR_PAD_LEFT);
        $payment_order_number = str_pad($this->getPaymentOrder()->getNumber(), 5, "0", STR_PAD_LEFT);
        $exection_date = $this->getPaymentOrder()->getExecutedAt()->format('Ymd');
        $outbound_invoice_number = str_pad(
            str_replace('_', '', $this->getOutboundInvoice()->getFormattedNumber()),
            15,
            "X",
            STR_PAD_RIGHT
        );

        return $outbound_invoice_number."-".$item_number.$exection_date.$payment_order_number;
    }

    public function getReferenceForVendor(): string
    {
        $reference = $this->getReference();
        $customer = str_replace(' ', '', $this->getPaymentOrder()->getCustomerName());
        $inbound_invoice = str_replace(' ', '', $this->getInboundInvoice()->number);
        $period = str_replace('/', '', $this->getInboundInvoice()->month);
        $deadline = $this->getInboundInvoice()->deadline()->first()->value;

        return substr("ADDWORKING-{$customer}-{$inbound_invoice}-{$period}{$deadline}-{$reference}", 0, 140);
    }
}
