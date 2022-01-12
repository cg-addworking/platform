<?php

namespace App\Models\Addworking\Mission;

use App\Models\Addworking\User\User;
use Components\Enterprise\AccountingExpense\Application\Models\AccountingExpense;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use Components\Mission\Mission\Domain\Interfaces\TrackingEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineEntityInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use UnexpectedValueException;

class MissionTrackingLine extends Model implements Htmlable, Searchable, TrackingLineEntityInterface
{
    use SoftDeletes, HasUuid, Viewable, Routable;

    protected $table = 'addworking_mission_mission_tracking_lines';

    protected $fillable = [
        'label',
        'quantity',
        'unit',
        'unit_price',
        'validation_vendor',
        'validation_customer',
        'reason_for_rejection',
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

    protected $attributes = [
        'quantity'            => 1,
        'unit_price'          => 0,
        'validation_vendor'   => self::STATUS_PENDING,
        'validation_customer' => self::STATUS_PENDING,
    ];

    protected $searchable = [];

    protected $routePrefix = "mission.tracking.line";

    protected $routeParameterAliases = [
        'line' => 'mission_tracking_line',
        'tracking' => "mission_tracking",
    ];

    public function __toString()
    {
        return (string) ($this->label ?? 'n/a');
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function missionTracking()
    {
        return $this->belongsTo(MissionTracking::class, 'tracking_id');
    }

    public function invoiceItems()
    {
        return $this->morphMany(InboundInvoiceItem::class, 'invoiceable');
    }

    public function accountingExpense()
    {
        return $this->belongsTo(AccountingExpense::class, 'accounting_expense_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setUnitAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableUnits())) {
            throw new UnexpectedValueException("Invalid unit: {$value}");
        }

        $this->attributes['unit'] = $value;
    }

    public function setReasonForRejectionAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableReasonForRejection())) {
            throw new UnexpectedValueException("Invalid reason for rejection");
        }

        $this->attributes['reason_for_rejection'] = $value;
    }

    public function setValidationVendorAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['validation_vendor'] = $value;
    }

    public function setValidationCustomerAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['validation_customer'] = $value;
    }

    public function getAmountAttribute(): float
    {
        return round(($this->quantity ?? 0) * ($this->unit_price ?? 0), 2);
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeQuantity($query, int $quantity)
    {
        return $query->where('quantity', $quantity);
    }

    public function scopeValidationCustomer($query, string $status)
    {
        return $query->where('validation_customer', $status);
    }

    public function scopeValidationVendor($query, string $status)
    {
        return $query->where('validation_vendor', $status);
    }

    public function scopeIsValidated($query)
    {
        return $query->where('validation_vendor', self::STATUS_VALIDATED)
            ->where('validation_customer', self::STATUS_VALIDATED);
    }

    public function scopeFilterVendor($query, $vendor)
    {
        return $query->whereHas('missionTracking', function ($query) use ($vendor) {
            return $query->whereHas('mission', function ($query) use ($vendor) {
                return $query->whereHas('vendor', function ($query) use ($vendor) {
                    $query->where(DB::raw('LOWER(name)'), 'like', "%" . strtolower($vendor) . "%");
                });
            });
        });
    }

    public function scopeFilterCustomer($query, $customer)
    {
        return $query->whereHas('missionTracking', function ($query) use ($customer) {
            return $query->whereHas('mission', function ($query) use ($customer) {
                return $query->whereHas('customer', function ($query) use ($customer) {
                    $query->where(DB::raw('LOWER(name)'), 'like', "%" . strtolower($customer) . "%");
                });
            });
        });
    }

    public function scopeFilterNumber($query, $number)
    {
        return $query->whereHas('missionTracking', function ($query) use ($number) {
            return $query->whereHas('mission', function ($query) use ($number) {
                $query->where(DB::raw('number'), 'like', "%" . $number . "%");
            });
        });
    }

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterVendor($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterCustomer($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterNumber($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public function isValidatedByCustomer()
    {
        return $this->validation_customer == MissionTrackingLine::STATUS_VALIDATED;
    }

    public function isValidatedByVendor()
    {
        return $this->validation_vendor == MissionTrackingLine::STATUS_VALIDATED;
    }

    public function isRejectedByCustomer()
    {
        return $this->validation_customer == MissionTrackingLine::STATUS_REJECTED;
    }

    public function isRejectedByVendor()
    {
        return $this->validation_vendor == MissionTrackingLine::STATUS_REJECTED;
    }

    public function isAnsweredByCustomer(): bool
    {
        return $this->isValidatedByCustomer() || $this->isRejectedByCustomer();
    }

    public function isAnsweredByVendor(): bool
    {
        return $this->isValidatedByVendor() || $this->isRejectedByVendor();
    }

    // ------------------------------------------------------------------------
    // Interface methods
    // ------------------------------------------------------------------------

    public function getId(): string
    {
        if (! $this->exists) {
            throw new \RuntimeException("this tracking line doesn't exists");
        }

        return $this->id;
    }

    public function getTracking(): TrackingEntityInterface
    {
        if (! $this->tracking->exists) {
            throw new \RuntimeException("no tracking is attached to this tracking line");
        }

        return $this->tracking;
    }

    public function setTracking(TrackingEntityInterface $tracking): self
    {
        $this->missionTracking()->associate($tracking->getId());

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    public function setUnitPrice(float $unit_price): self
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getVendorValidationStatus(): ?string
    {
        return $this->validation_vendor;
    }

    public function setVendorValidationStatus(?string $status): self
    {
        $this->validation_vendor = $status;

        return $this;
    }

    public function getCustomerValidationStatus(): ?string
    {
        return $this->validation_customer;
    }

    public function setCustomerValidationStatus(?string $status): self
    {
        $this->validation_customer = $status;

        return $this;
    }

    public function getReasonForRejection(): ?string
    {
        return $this->reason_for_rejection;
    }

    public function setReasonForRejection(?string $reason): self
    {
        $this->reason_for_rejection = $reason;

        return $this;
    }

    public static function getAvailableUnits(): array
    {
        return Mission::getAvailableUnits();
    }

    public static function getAvailableReasonForRejection(bool $trans = false): array
    {
        $reasons = [
            self::REJECTED_FOR_ERROR_AMOUNT,
            self::REJECTED_FOR_ERROR_QUANTITY,
            self::REJECTED_FOR_MISSION_NOT_COMPLETED,
            self::REJECTED_FOR_MISSION_NOT_REALIZED,
            self::REJECTED_FOR_OTHER,
        ];

        if ($trans) {
            $reasons = array_trans(
                array_mirror($reasons),
                'mission.tracking.line.reason_for_rejection.'
            );
        }

        return $reasons;
    }

    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_VALIDATED,
            self::STATUS_REJECTED,
        ];
    }

    public function getMissionTracking()
    {
        return $this->missionTracking;
    }
}
