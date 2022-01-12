<?php

namespace Components\Billing\Outbound\Application\Models;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Models\Concerns\OutboundInvoiceScopes;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPaymentOutboundInvoice;
use Components\Infrastructure\Scopes\DateScopes;
use Components\Infrastructure\Scopes\StatusScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrderItem;
use DateTime;

class OutboundInvoice extends Model implements OutboundInvoiceInterface, Searchable
{
    use HasUuid,
        OutboundInvoiceScopes,
        DateScopes,
        StatusScopes,
        SoftDeletes,
        Routable,
        Viewable;

    protected $table = "addworking_billing_outbound_invoices";

    protected $routePrefix = "addworking.billing.outbound";

    protected $viewPrefix = "outbound_invoice::";

    protected $fillable = [
        'month',
        'invoiced_at',
        'due_at',
        'status',
        'number',
        'is_published',
        'legal_notice',
        'reverse_charge_vat',
        'dailly_assignment',
        'validated_at',
        'validated_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'invoiced_at',
        'due_at',
        'validated_at',
    ];

    protected $attributes = [
        'is_published' => true,
        'reverse_charge_vat' => false,
        'dailly_assignment'=> false,
    ];

    protected $searchable = [
        'month',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function deadline()
    {
        return $this->belongsTo(DeadlineType::class)->withDefault();
    }

    public function items()
    {
        return $this->hasMany(OutboundInvoiceItem::class)->orderBy('vendor_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(OutboundInvoice::class)->withDefault();
    }

    public function receivedPaymentOutbound()
    {
        return $this->hasMany(ReceivedPaymentOutboundInvoice::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function paymentOrderItem()
    {
        return $this->hasMany(PaymentOrderItem::class);
    }

    public function validatedBy()
    {
        return $this->belongsTo(User::class, 'validated_by')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Setters & Getters
    // ------------------------------------------------------------------------

    public function setMonth(string $month)
    {
        $this->month = $month;
    }

    public function setInvoicedAt(string $invoicedAt)
    {
        $this->invoiced_at = $invoicedAt;
    }

    public function setEnterprise($enterprise)
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setDeadline($deadline)
    {
        $this->deadline()->associate($deadline);
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setDueAt($dueAt)
    {
        $this->due_at = $dueAt;
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function getMonth():? string
    {
        return $this->month;
    }

    public function getDeadline()
    {
        return $this->deadline()->first();
    }

    public function getNumber():? string
    {
        return $this->number;
    }

    public function getEnterprise()
    {
        return $this->enterprise;
    }

    public function getFormattedNumber():? string
    {
        if ($this->getNumber()) {
            return sprintf('CPS1_%s_%s', $this->getEnterprise()->number, $this->getNumber());
        }

        return 'n/a';
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy()->first();
    }

    public function setFile($file)
    {
        $this->file()->associate($file)->save();
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getInvoicedAt()
    {
        return $this->invoiced_at;
    }

    public function getDueAt()
    {
        return $this->due_at;
    }

    public function getAmountBeforeTaxes(): float
    {
        $fees = Fee::whereHas('outboundInvoice', function ($query) {
            $query->where('id', $this->getId());
        })->get();

        $totalFees = $fees->reduce(function ($carry, Fee $fee) {
            return $carry + $fee->getAmountBeforeTaxes();
        }, 0);

        $totalItems = $this->items->reduce(function ($carry, OutboundInvoiceItem $item) {
            return $carry + $item->getAmountBeforeTaxes();
        }, 0);

        return round($totalItems + $totalFees, 2);
    }

    public function getAmountOfTaxes(): float
    {
        $fees = Fee::whereHas('outboundInvoice', function ($query) {
            $query->where('id', $this->getId());
        })->get();

        $totalFees = $fees->reduce(function ($carry, Fee $fee) {
            return $carry + $fee->getAmountOfTaxes();
        }, 0);

        $totalItems = $this->items->reduce(function ($carry, OutboundInvoiceItem $item) {
            return $carry + $item->getAmountOfTaxes();
        }, 0);

        return round($totalItems + $totalFees, 2);
    }

    public function getAmountAllTaxesIncluded(): float
    {
        return round($this->getAmountBeforeTaxes() + $this->getAmountOfTaxes(), 2);
    }

    public function getPublishStatus(): bool
    {
        return $this->is_published;
    }

    public function getLegalNotice():? string
    {
        return $this->legal_notice;
    }

    public function setLegalNotice(?string $legalNotice)
    {
        $this->legal_notice = $legalNotice;
    }

    public function getLabelAttribute()
    {
        return sprintf(
            "Facture N° %s, %s, %s, %s",
            $this->getFormattedNumber(),
            $this->getMonth(),
            $this->getDeadline()->display_name ?? "n/a",
            $this->getEnterprise()->name ?? "n/a"
        );
    }

    public function getLabel(): string
    {
        return sprintf(
            "Facture N° %s, %s, %s, %s",
            $this->getFormattedNumber(),
            $this->getMonth(),
            $this->getDeadline()->display_name ?? "n/a",
            $this->getEnterprise()->name ?? "n/a"
        );
    }

    public function getValidatedAt()
    {
        return $this->validated_at;
    }

    public function getValidatedBy(): ?User
    {
        return $this->validatedBy()->first();
    }

    public function setReverseChargeVat(bool $reverseChargeVat)
    {
        $this->reverse_charge_vat = $reverseChargeVat;
    }

    public function setDaillyAssignment(bool $daillyAssignment)
    {
        $this->dailly_assignment = $daillyAssignment;
    }

    public function getReverseChargeVat(): bool
    {
        return $this->reverse_charge_vat;
    }

    public function getDaillyAssignment(): bool
    {
        return $this->dailly_assignment;
    }

    public function setParent($outboundInvoice)
    {
        $this->parent()->associate($outboundInvoice);
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setValidatedBy(?User $user)
    {
        $this->validatedBy()->associate($user)->save();
    }

    public function setValidateAt($validated_at)
    {
        $this->validated_at = $validated_at;
    }
}
