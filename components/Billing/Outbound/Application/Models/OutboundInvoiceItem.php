<?php
namespace Components\Billing\Outbound\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Billing\VatRate;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;
use Components\Infrastructure\Scopes\DateScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutboundInvoiceItem extends Model implements OutboundInvoiceItemInterface
{
    use HasUuid,
        DateScopes,
        SoftDeletes;

    protected $table = "addworking_billing_outbound_invoice_items";

    protected $fillable = [
        'label',
        'quantity',
        'unit_price',
        'number',
    ];

    protected $casts = [
        'quantity'   => 'float',
        'unit_price' => 'float',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function outboundInvoice()
    {
        return $this->belongsTo(OutboundInvoice::class)->withDefault();
    }

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function vatRate()
    {
        return $this->belongsTo(VatRate::class)->withDefault();
    }

    public function inboundInvoiceItem()
    {
        return $this->belongsTo(InboundInvoiceItem::class)->withDefault();
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function parent()
    {
        return $this->belongsTo(OutboundInvoiceItem::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Setters & Getters
    // ------------------------------------------------------------------------

    public function setInvoice(OutboundInvoiceInterface $invoice)
    {
        $this->outboundInvoice()->associate($invoice);
    }

    public function setVatRate(string $id)
    {
        $this->vatRate()->associate($id);
    }

    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    public function setQuantity(float $quantity)
    {
        $this->quantity = $quantity;
    }

    public function setUnitPrice(float $unitPrice)
    {
        $this->unit_price = $unitPrice;
    }

    public function setInboundInvoiceItem(string $id)
    {
        $this->inboundInvoiceItem()->associate($id);
    }

    public function setVendor(string $id)
    {
        $this->vendor()->associate($id);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setParent($outboundInvoiceItem)
    {
        $this->parent()->associate($outboundInvoiceItem);
    }

    public function getInboundInvoice()
    {
        return $this->inboundInvoiceItem->inboundInvoice;
    }

    public function getOutboundInvoice()
    {
        return $this->outboundInvoice;
    }

    public function getVatRate()
    {
        return $this->vatRate()->first();
    }

    public function getInboundInvoiceItem()
    {
        return $this->inboundInvoiceItem;
    }

    public function getVendor()
    {
        return $this->vendor()->first();
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getAmountBeforeTaxes(): float
    {
        return round($this->getQuantity() * $this->getUnitPrice(), 2);
    }

    public function getAmountOfTaxes(): float
    {
        return $this->getAmountBeforeTaxes() * $this->getVatRate()->value;
    }

    public function getAmountAllTaxesIncluded(): float
    {
        return $this->getAmountBeforeTaxes() + $this->getAmountOfTaxes();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNumber():? string
    {
        return $this->number;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setIsCanceled(bool $bool)
    {
        $this->is_canceled = $bool;
    }
}
