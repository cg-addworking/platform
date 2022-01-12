<?php

namespace Components\Billing\Outbound\Application\Models;

use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Billing\VatRate;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Models\Concerns\FeeScopes;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Domain\Classes\FeeInterface;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model implements FeeInterface, Searchable
{
    use HasUuid,
        FeeScopes,
        SoftDeletes;

    protected $table = "addworking_billing_addworking_fees";

    protected $fillable = [
        'label',
        'type',
        'amount_before_taxes',
        'number'
    ];

    protected $casts = [
        'amount_before_taxes' => 'float',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function outboundInvoice()
    {
        return $this->belongsTo(OutboundInvoice::class)->withDefault();
    }

    public function invoiceParameter()
    {
        return $this->belongsTo(InvoiceParameter::class)->withDefault();
    }

    public function vatRate()
    {
        return $this->belongsTo(VatRate::class)->withDefault();
    }

    public function outboundInvoiceItem()
    {
        return $this->belongsTo(OutboundInvoiceItem::class)->withDefault();
    }

    public function customer()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(Fee::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Setters & Getters
    // ------------------------------------------------------------------------

    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function setAmountBeforeTaxes(float $amount, float $fees)
    {
        $this->amount_before_taxes = round($amount * $fees, 2);
    }

    public function setNegativeAmountBeforeTaxes(float $fees)
    {
        $this->amount_before_taxes = round(0 - $fees, 2);
    }

    public function setVendor($vendor)
    {
        $this->vendor()->associate($vendor);
    }

    public function setItem($item)
    {
        $this->outboundInvoiceItem()->associate($item);
    }

    public function setInvoice($invoice)
    {
        $this->outboundInvoice()->associate($invoice);
    }

    public function setInvoiceParameter($param)
    {
        $this->invoiceParameter()->associate($param);
    }

    public function setVatRate($vatRate)
    {
        $this->vatRate()->associate($vatRate);
    }

    public function setCustomer($customer)
    {
        $this->customer()->associate($customer);
    }

    public function setParent($fee)
    {
        $this->parent()->associate($fee);
    }

    public function setIsCanceled(bool $bool)
    {
        $this->is_canceled = $bool;
    }
    
    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function getVatRate()
    {
        return $this->vatRate()->first();
    }

    public function getAmountBeforeTaxes(): ?float
    {
        return $this->amount_before_taxes;
    }

    public function getAmountOfTaxes(): float
    {
        return $this->getAmountBeforeTaxes() * $this->getVatRate()->value;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getVendor()
    {
        return $this->vendor()->first();
    }

    public function getOutboundInvoiceItem()
    {
        return $this->outboundInvoiceItem()->first();
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getOutboundInvoice()
    {
        return $this->outboundInvoice()->first();
    }

    public function getCustomer()
    {
        return $this->customer()->first();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getParent()
    {
        return $this->parent;
    }
}
