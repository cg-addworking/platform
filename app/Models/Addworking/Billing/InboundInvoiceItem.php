<?php

namespace App\Models\Addworking\Billing;

use App\Contracts\Addworking\Billing\InvoiceItem;
use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Mission;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use UnexpectedValueException;

class InboundInvoiceItem extends Model implements Htmlable, InvoiceItem
{
    use HasUuid, Viewable, Routable, SoftDeletes;

    protected $table = "addworking_billing_inbound_invoice_items";

    protected $fillable = [
        'label',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'quantity'            => 'float',
        'unit_price'          => 'float',
    ];

    protected $routePrefix = "addworking.billing.inbound_invoice_item";

    public function __toString()
    {
        return (string) $this->label;
    }

    public function newCollection(array $models = [])
    {
        return new InvoiceItemCollection($models);
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function invoice()
    {
        return $this->inboundInvoice();
    }

    public function inboundInvoice()
    {
        return $this->belongsTo(InboundInvoice::class)->withDefault();
    }

    public function vatRate()
    {
        return $this->belongsTo(VatRate::class)->withDefault();
    }

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }

    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function outboundInvoiceItem()
    {
        return $this->hasOne(\Components\Billing\Outbound\Application\Models\OutboundInvoiceItem::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeEnterprise($query, Enterprise $enterprise)
    {
        return $query->whereHas('invoice', function ($query) use ($enterprise) {
            return $query->ofEnterprise($enterprise);
        });
    }

    public function scopeWhereInboundInvoice($query, InboundInvoice $inbound_invoice)
    {
        return $query->whereHas('invoice', function ($query) use ($inbound_invoice) {
            return $query->where('id', $inbound_invoice->id);
        });
    }

    // ------------------------------------------------------------------------
    // Misc
    // ------------------------------------------------------------------------

    public function getAmountBeforeTaxes(): float
    {
        return round($this->quantity * $this->unit_price, 2);
    }

    public function getAmountOfTaxes(): float
    {
        return $this->getAmountBeforeTaxes() * $this->vatRate->value;
    }

    public function getAmountAllTaxesIncluded(): float
    {
        return $this->getAmountBeforeTaxes() + $this->getAmountOfTaxes();
    }
}
