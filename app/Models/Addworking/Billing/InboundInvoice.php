<?php

namespace App\Models\Addworking\Billing;

use Components\Common\Common\Application\Models\Action;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Contracts\Billing\Invoice;
use App\Contracts\Models\Searchable;
use App\Events\InboundInvoiceSaved;
use App\Mail\NewInboundUploaded;
use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use App\Models\Addworking\Common\Concerns\File\HasAttachments;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Concerns\HasFilters;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrderItem;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use UnexpectedValueException;

class InboundInvoice extends Model implements Htmlable, Searchable
{
    use HasUuid,
        Routable,
        Viewable,
        Commentable,
        HasFilters,
        HasAttachments,
        SoftDeletes;

    const STATUS_TO_VALIDATE = 'to_validate';
    const STATUS_PENDING     = 'pending';
    const STATUS_VALIDATED   = 'validated';
    const STATUS_PAID        = 'paid';

    // NEW STATUS
    const STATUS_PENDING_ASSOCIATION = "pending_association";
    const STATUS_ASSOCIATED = "associated";

    const COMPLIANCE_STATUS_PENDING = 'pending';
    const COMPLIANCE_STATUS_VALID   = 'valid';
    const COMPLIANCE_STATUS_INVALID = 'invalid';

    protected $table = "addworking_billing_inbound_invoices";

    protected $fillable = [
        'enterprise', /* virtual */
        'status',
        'number',
        'month',
        'invoiced_at',
        'due_at',
        'amount_before_taxes',
        'amount_of_taxes',
        'amount_all_taxes_included',
        'note',
        'admin_amount', // @deprecated
        'admin_amount_of_taxes', // @deprecated
        'admin_amount_all_taxes_included', // @deprecated
        'compliance_status',
        'is_factoring',
        'items_not_found',
    ];

    protected $casts = [
        'amount_before_taxes' => "float",
        'amount_of_taxes' => "float",
        'amount_all_taxes_included' => "float",
        'items_not_found' => "boolean",
        'admin_amount' => "float", // @deprecated
        'admin_amount_of_taxes' => "float", // @deprecated
        'admin_amount_all_taxes_included' => "float", // @deprecated
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'invoiced_at',
        'due_at',
    ];

    protected $attributes = [
        'status' => self::STATUS_TO_VALIDATE,
        'is_factoring' => false,
        'items_not_found' => false,
    ];

    protected $searchable = [
        'number'
    ];

    protected $routePrefix = "addworking.billing.inbound_invoice";

    protected $dispatchesEvents = [
        'saved'  => InboundInvoiceSaved::class,
    ];

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            foreach ($model->items as $item) {
                if ($item->invoiceable) {
                    $item->invoiceable()->dissociate();
                }
                $item->delete();
            };
        });
    }

    public function __toString()
    {
        return (string) $this->getLabelAttribute();
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function customer()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function items()
    {
        return $this->hasMany(InboundInvoiceItem::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }

    public function outboundInvoice()
    {
        return $this->belongsTo(OutboundInvoice::class)->withDefault();
    }

    public function deadline()
    {
        return $this->belongsTo(DeadlineType::class)->withDefault();
    }

    public function paymentOrderItem()
    {
        return $this->hasOne(PaymentOrderItem::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function actions()
    {
        return $this->morphMany(Action::class, 'trackable');
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterEnterprise($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterCustomer($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->withNumber($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeWithNumber($query, $number)
    {
        return $query->where('number', 'like', "%{$number}%");
    }

    public function scopeOfCustomer($query, Enterprise $enterprise)
    {
        return $query->whereHas('customer', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        });
    }

    public function scopeOfCustomers($query, User $user)
    {
        return $query->whereHas('customer', function ($query) use ($user) {
            $query->whereIn('id', $user->enterprises->pluck('id'));
        });
    }

    public function scopeWithId($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeOfEnterprise($query, Enterprise $enterprise)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        });
    }

    public function scopeOfEnterprises($query, Collection $enterprises)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprises) {
            $query->whereIn('id', $enterprises->pluck('id'));
        });
    }

    public function scopeOfOutboundInvoice($query, OutboundInvoice $outbound_invoice)
    {
        return $query->whereHas('outboundInvoice', fn($query) => $query->where('id', $outbound_invoice->id));
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeStatuses($query, $status)
    {
        return $query->whereIn('status', Arr::wrap($status));
    }

    public function scopeMonth($query, $months)
    {
        return $query->whereIn('month', Arr::wrap($months));
    }

    public function scopeCustomer($query, $customers)
    {
        return $query->whereHas('customer', function ($query) use ($customers) {
            $query->whereIn('name', Arr::wrap($customers));
        });
    }
    public function scopeVendors($query, $vendors)
    {
        return $query->whereHas('enterprise', function ($query) use ($vendors) {
            $query->whereIn('id', Arr::wrap($vendors));
        });
    }

    public function scopeFilterEnterprise($query, $enterprise)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where(DB::raw('LOWER(name)'), 'like', "%" .  strtolower($enterprise) . "%");
        });
    }

    public function scopeFilterCustomer($query, $enterprise)
    {
        return $query->whereHas('customer', function ($query) use ($enterprise) {
            $query->where(DB::raw('LOWER(name)'), 'like', "%" . strtolower($enterprise) . "%");
        });
    }

    public function scopeFilterCreatedAt($query, $date)
    {
        return $query->where('created_at', 'like', "%{$date}%");
    }

    public function scopeExceptToValidate($query)
    {
        return $query->where('status', '!=', self::STATUS_TO_VALIDATE);
    }

    public function scopeExceptPending($query)
    {
        return $query->where('status', '!=', self::STATUS_PENDING);
    }

    public function scopeExceptValidated($query)
    {
        return $query->where('status', '!=', self::STATUS_VALIDATED);
    }

    public function scopeExceptPaid($query)
    {
        return $query->where('status', '!=', self::STATUS_PAID);
    }

    public function scopeValidated($query)
    {
        return $query->where('status', self::STATUS_VALIDATED);
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setEnterpriseAttribute($value)
    {
        return $this->enterprise()->associate($value);
    }

    public function setMonthAttribute($value)
    {
        if (!preg_match('~(\d{2})/(\d{4})~', $value, $matches)) {
            throw new UnexpectedValueException("Invalid month format (MM/YYYY)");
        }

        list(, $month, $year) = $matches;

        if ($month > 12) {
            throw new UnexpectedValueException("Invalid month: {$month}");
        }

        if ($year < 2016) {
            throw new UnexpectedValueException("Invalid year: {$year}");
        }

        $this->attributes['month'] = "{$month}/{$year}";
    }

    /**
     * @deprecated v0.51.1
     * use InboundInvoice::isLocked()
     */
    public function getIsLockedAttribute()
    {
        return $this->isLocked();
    }

    public function getLabelAttribute()
    {
        list($month, $year) = explode('/', $this->month) + [null, null];
        $month              = month_fr((int) $month);
        $enterprise         = $this->enterprise->name;
        $customer           = $this->customer->name;
        $deadline           = __("invoice.inbound_invoice.deadline_$this->deadline");

        return "Facture {$this->number} {$enterprise} de {$month} {$year} pour {$customer} ($deadline)";
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
    }

    // ------------------------------------------------------------------------
    // Miscelaneous
    // ------------------------------------------------------------------------

    public function validateAmounts(): bool
    {
        return $this->items()->exists()
            && ($this->amount_before_taxes == round($this->items->getAmountBeforeTaxes(), 2))
            && ($this->amount_all_taxes_included == round($this->items->getAmountAllTaxesIncluded(), 2));
            //&& $this->amount_of_taxes === $this->items->getAmountOfTaxes()
    }

    public static function getAvailableMonths()
    {
        $periods = CarbonPeriod::create(
            Carbon::today()->subMonths(24)->format('Y-m'),
            '1 month',
            Carbon::today()->format('Y-m')
        )->toArray();

        return array_reverse(array_mirror(array_map(fn ($month) => $month->format('m/Y'), $periods)));
    }

    public static function getAvailableStatuses(bool $trans = false): array
    {
        $statuses = [
            self::STATUS_TO_VALIDATE         => "À valider",
            self::STATUS_PENDING             => "En attente",
            self::STATUS_VALIDATED           => "Validée",
            self::STATUS_PAID                => "Payée",
        ];

        return $trans ? $statuses : array_keys($statuses);
    }

    public static function getAvailableComplianceStatuses(bool $trans = false): array
    {
        $statuses = [
            self::COMPLIANCE_STATUS_PENDING => "En attente",
            self::COMPLIANCE_STATUS_VALID   => "Valide",
            self::COMPLIANCE_STATUS_INVALID => "Invalide",
        ];

        return $trans ? $statuses : array_keys($statuses);
    }

    public function isLocked(): bool
    {
        return in_array($this->status, [Invoice::STATUS_PENDING, Invoice::STATUS_VALIDATED, Invoice::STATUS_PAID]);
    }

    /**
     * @deprecated v0.59.0
     */
    public function getAvailableOutboundInvoices()
    {
        return OutboundInvoice::query()
            ->ofCustomer($this->customer)
            ->whereIn('status', [
                OutboundInvoice::STATUS_PENDING,
                OutboundInvoice::STATUS_FEES_CALCULATED,
                OutboundInvoice::STATUS_FILE_GENERATED
            ])->orderBy('number')->get();
    }

    public function hasMissiontTrackingLines(): bool
    {
        return $this->items->contains(fn($inboundItem) => ! is_null($inboundItem->invoiceable));
    }

    public function isMissionTrackingLinesValidatedByCustomer(): bool
    {
        if ($this->items->count() == 0) {
            return false;
        }

        return $this->items->every(
            fn($inboundItem) => $inboundItem->invoiceable ? $inboundItem->invoiceable->isValidatedByCustomer() : false
        );
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy()->first();
    }

    public function getOutboundInvoice()
    {
        return $this->outboundInvoice()->first();
    }

    public function getInboundInvoiceItemNotFound(): bool
    {
        return $this->items_not_found;
    }

    public function setIsFactoring($is_factoring): void
    {
        $this->is_factoring = $is_factoring;
    }
}
