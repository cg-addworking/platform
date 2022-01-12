<?php

namespace Components\Enterprise\InvoiceParameter\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use Carbon\Carbon;
use Components\Enterprise\InvoiceParameter\Application\Models\Scopes\InvoiceParameterScope;
use Components\Enterprise\InvoiceParameter\Domain\Classes\InvoiceParameterInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceParameter extends Model implements InvoiceParameterInterface
{
    use HasUuid,
        SoftDeletes,
        InvoiceParameterScope;

    protected $table = "addworking_enterprise_invoice_parameters";

    protected $fillable = [
        'analytic_code',
        'discount_starts_at',
        'discount_ends_at',
        'discount_amount',
        'billing_floor_amount',
        'billing_cap_amount',
        'default_management_fees_by_vendor',
        'custom_management_fees_by_vendor',
        'fixed_fees_by_vendor_amount',
        'subscription_amount',
        'starts_at',
        'ends_at',
        'invoicing_from_inbound_invoice',
        'vendor_creating_inbound_invoice_items',
        'number',
    ];

    protected $casts = [
        'discount_amount'                   => "float",
        'billing_floor_amount'              => "float",
        'billing_cap_amount'                => "float",
        'default_management_fees_by_vendor' => "float",
        'custom_management_fees_by_vendor'  => "float",
        'fixed_fees_by_vendor_amount'       => "float",
        'subscription_amount'               => "float",
        'invoicing_from_inbound_invoice'    => 'boolean',
        'vendor_creating_inbound_invoice_items' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'discount_starts_at',
        'discount_ends_at',
        'starts_at',
        'ends_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function iban()
    {
        return $this->belongsTo(Iban::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------

    public function getDefaultManagementFeesByVendor(): ?float
    {
        return $this->default_management_fees_by_vendor;
    }

    public function getCustomManagementFeesByVendor(): ?float
    {
        return $this->custom_management_fees_by_vendor;
    }

    public function getFixedFeesByVendor(): ?float
    {
        return $this->fixed_fees_by_vendor_amount;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSubscription(): ?float
    {
        return $this->subscription_amount;
    }

    public function getIban()
    {
        return $this->iban()->first();
    }

    public function getDiscount()
    {
        return $this->discount_amount;
    }

    public function getDiscountEndsAt()
    {
        return $this->discount_ends_at;
    }

    public function getDiscountStartsAt()
    {
        return $this->discount_starts_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getEnterprise()
    {
        return $this->enterprise()->first();
    }

    public function getAnalyticCode(): ?string
    {
        return $this->analytic_code;
    }

    public function getBillingFloorAmount(): ?float
    {
        return $this->billing_floor_amount;
    }

    public function getBillingCapAmount(): ?float
    {
        return $this->billing_cap_amount;
    }

    public function getStartsAt()
    {
        return $this->starts_at;
    }

    public function getEndsAt()
    {
        return $this->ends_at;
    }

    public function getInvoicingFromInboundInvoice(): ?bool
    {
        return $this->invoicing_from_inbound_invoice;
    }

    public function getStatus(): bool
    {
        return Carbon::now()->between($this->getStartsAt(), $this->getEndsAt());
    }

    public function getVendorCreatingInboundInvoiceItems(): ?bool
    {
        return $this->vendor_creating_inbound_invoice_items;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------

    public function setEnterprise($enterprise): void
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setIban($iban): void
    {
        $this->iban()->associate($iban);
    }

    public function setDefaultManagementFeesByVendor(float $value): void
    {
        if ($value < 0) {
            throw new \UnexpectedValueException("Value cannot be negative");
        }

        $this->default_management_fees_by_vendor = $value/100;
    }

    public function setCustomManagementFeesByVendor(float $value): void
    {
        if ($value < 0) {
            throw new \UnexpectedValueException("Value cannot be negative");
        }

        $this->custom_management_fees_by_vendor = $value/100;
    }

    public function setFixedFeesByVendorAmount(float $value): void
    {
        $this->fixed_fees_by_vendor_amount = $value;
    }

    public function setSubscriptionAmount(float $value): void
    {
        $this->subscription_amount = $value;
    }

    public function setDiscountAmount(float $value): void
    {
        $this->discount_amount = $value;
    }

    public function setDiscountEndsAt(?string $date): void
    {
        $this->discount_ends_at = $date;
    }

    public function setDiscountStartsAt(?string $date): void
    {
        $this->discount_starts_at = $date;
    }

    public function setAnalyticCode(?string $value): void
    {
        $this->analytic_code = $value;
    }

    public function setBillingFloorAmount(float $value): void
    {
        $this->billing_floor_amount = $value;
    }

    public function setBillingCapAmount(float $value): void
    {
        $this->billing_cap_amount = $value;
    }

    public function setStartsAt(string $date): void
    {
        $this->starts_at = $date;
    }

    public function setEndsAt(?string $date): void
    {
        $this->ends_at = $date;
    }

    public function setInvoicingFromInboundInvoice(bool $value): void
    {
        $this->invoicing_from_inbound_invoice = $value;
    }

    public function setVendorCreatingInboundInvoiceItems(bool $value): void
    {
        $this->vendor_creating_inbound_invoice_items = $value;
    }

    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }
}
