<?php

namespace App\Models\Addworking\Mission;

use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Concerns\Mission\HasMilestones;
use App\Models\Addworking\Mission\Concerns\Mission\HasStatuses;
use App\Models\Addworking\Mission\Concerns\Mission\HasTrackings;
use App\Models\Addworking\User\User;
use App\Models\Concerns\HasMetadata;
use App\Models\Concerns\HasNumber;
use App\Models\TseExpressMedical\Mission\MissionDetail as TseExpressMedicalMissionDetail;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseEntityInterface;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;
use Components\Mission\Offer\Application\Models\Offer as SectorOffer;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use UnexpectedValueException;
use Venturecraft\Revisionable\RevisionableTrait as Revisionable;

class Mission extends Model implements Htmlable, Searchable, MissionEntityInterface
{
    use Revisionable,
        HasNumber,
        HasUuid,
        Viewable,
        Routable,
        HasMetadata,
        HasMilestones,
        HasTrackings,
        Commentable,
        HasStatuses;

    protected $table = 'addworking_mission_missions';

    protected $fillable = [
        'number',
        'status',
        'label',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'quantity',
        'unit_price',
        'unit',
        'external_id',
        'closed_by',
        'closed_at',
        'note',
        'milestone_type',
        'amount'
    ];

    protected $dates = [
        'starts_at',
        'ends_at',
        'created_at',
        'updated_at',
        'closed_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'float',
    ];

    protected $keepRevisionOf = [
        'starts_at',
        'ends_at',
        'quantity',
        'unit_price',
        'unit',
        'external_id'
    ];

    protected $searchable = [
        'label',
        'number',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $calculated_amount = 0;

            if (isset($model->attributes['quantity']) && isset($model->attributes['unit_price'])) {
                $calculated_amount = $model->attributes['quantity'] * $model->attributes['unit_price'];
            }

            if ($calculated_amount !== 0) {
                $model->attributes['amount'] = $calculated_amount;
            }
        });
    }

    public function __toString()
    {
        return (string) $this->label;
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function inboundInvoiceItem()
    {
        return $this->belongsTo(InboundInvoiceItem::class)->withDefault();
    }

    public function outboundInvoiceItem()
    {
        return $this->belongsTo(OutboundInvoiceItem::class)->withDefault();
    }

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class, 'vendor_enterprise_id')->withDefault();
    }

    public function customer()
    {
        return $this->belongsTo(Enterprise::class, 'customer_enterprise_id')->withDefault();
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'addworking_common_files_has_missions')
            ->withPivot('name')
            ->withTimestamps();
    }

    public function purchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::class, 'mission_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Enterprise::class, 'created_by')->withDefault();
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by')->withDefault();
    }

    public function tseExpressMedicalMissionDetail()
    {
        return $this->hasOne(TseExpressMedicalMissionDetail::class)->withDefault();
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id')->withDefault();
    }

    public function proposalResponse()
    {
        return $this->belongsTo(ProposalResponse::class, 'proposal_response_id')->withDefault();
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id')->withDefault();
    }

    public function sectorOffer()
    {
        return $this->belongsTo(SectorOffer::class, 'offer_id')->withDefault();
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id')->withDefault();
    }

    public function referent()
    {
        return $this->belongsTo(User::class, 'referent_id')->withDefault();
    }

    public function workField()
    {
        return $this->belongsTo(WorkField::class, 'workfield_id')->withDefault();
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'addworking_mission_missions_has_departments')
            ->withTimestamps();
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'mission_id');
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

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
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeOfVendor($query, Enterprise $enterprise)
    {
        return $query->where('vendor_enterprise_id', $enterprise->id);
    }

    public function scopeOfCustomer($query, Enterprise $enterprise)
    {
        return $query->where('customer_enterprise_id', $enterprise->id);
    }

    public function scopeOfEnterprise($query, Enterprise $enterprise)
    {
        return $query->where(function ($query) use ($enterprise) {
            return $query
                ->orWhere('customer_enterprise_id', $enterprise->id)
                ->orWhere('vendor_enterprise_id', $enterprise->id);
        });
    }

    public function scopeFilterVendor($query, $enterprise)
    {
        return $query->whereHas('vendor', function ($query) use ($enterprise) {
            return $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($enterprise)."%");
        });
    }

    public function scopeFilterCustomer($query, $enterprise)
    {
        return $query->whereHas('customer', function ($query) use ($enterprise) {
            return $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($enterprise)."%");
        });
    }

    public function scopeNumber($query, int $number)
    {
        return $query->where('number', $number);
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeInProgress($query)
    {
        return $query
            ->where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>=', date('Y-m-d 23:59:59'))
            ->orWhereNull('ends_at');
    }

    public function scopeFilterStartsAt($query, $date)
    {
        return $query->where('starts_at', 'like', "%{$date}%");
    }

    public function scopeFilterLabel($query, $label)
    {
        return $query->where(DB::raw('LOWER(label)'), 'like', "%". strtolower($label)."%");
    }

    public function scopeOfReferent($query, $enterprise, $referent)
    {
        return $query->whereHas('vendor', function ($query) use ($referent, $enterprise) {
            $query->ofReferent($enterprise, $referent);
        });
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------
    public function setContract(ContractEntityInterface $contract): void
    {
        $this->contract()->associate($contract);
    }

    public function setSectorOffer(OfferEntityInterface $offer)
    {
        $this->sectorOffer()->associate($offer);
    }

    public function setWorkField($value): void
    {
        $this->workField()->associate($value);
    }

    public function setAnalyticCode(?string $value): void
    {
        $this->analytic_code = $value;
    }

    public function setExternalId(?string $value): void
    {
        $this->external_id = $value;
    }

    public function setDepartments(array $values): void
    {
        $this->departments()->attach($values);
    }

    public function unsetDepartments($values): void
    {
        $this->departments()->detach($values);
    }

    public function setQuantityAttribute($value)
    {
        if ($value < 0) {
            throw new UnexpectedValueException("Invalid quantity");
        }

        $this->attributes['quantity'] = $value;
    }

    public function setUnitAttribute($value)
    {
        if (!empty($value) && !in_array($value, self::getAvailableUnits())) {
            throw new UnexpectedValueException("Invalid unit");
        }

        $this->attributes['unit'] = $value;
    }

    public function setStatusAttribute($value)
    {
        if (!in_array($value, self::getAvailableStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['status'] = $value;
    }

    public function setStartsAt($value): void
    {
        $this->starts_at = $value;
    }

    public function setEndsAt($value): void
    {
        $this->ends_at = $value;
    }

    // ------------------------------------------------------------------------
    // Miscelaneous
    // ------------------------------------------------------------------------

    public function newCollection(array $models = [])
    {
        return new MissionCollection($models);
    }
    public function hasMilestoneType(): bool
    {
        return is_null($this->milestone_type) ? false : true;
    }

    public static function fromExternalId($id): self
    {
        return self::where('external_id', $id)->firstOrFail();
    }

    /**
     * @deprecated in favor of getAvailableUnits
     */
    public static function getUnits(): array
    {
        return [self::UNIT_HOURS, self::UNIT_DAYS, self::UNIT_FIXED_FEES, self::UNIT_UNIT];
    }

    public function getAvailableInboundInvoiceItems()
    {
        return $this->vendor->exists
            ? InboundInvoiceItem::enterprise($this->vendor)
            : InboundInvoiceItem::query();
    }

    public static function getAvailableUnits(): array
    {
        return [
            self::UNIT_HOURS,
            self::UNIT_DAYS,
            self::UNIT_FIXED_FEES,
            self::UNIT_UNIT
        ];
    }

    public static function getAvailableLocations()
    {
        return Department::orderBy('insee_code', 'asc')
            ->get()
            ->mapWithKeys(function ($department) {
                return [
                    $department->display_name => "({$department->insee_code}) {$department->display_name}",
                ];
            });
    }

    public static function createFromProposal(Proposal $proposal)
    {
        $mission = new Mission;
        $mission->customer()->associate($proposal->missionOffer->customer);
        $mission->vendor()->associate($proposal->vendor);
        $mission->proposal()->associate($proposal);
        $mission->createdBy()->associate($proposal->missionOffer->customer);

        $mission->label      = 'Mission - '
            .$proposal->missionOffer->label.' - '
            .$proposal->missionOffer->customer.' - '
            .$proposal->vendor->name;

        $mission->starts_at  = $proposal->missionOffer->starts_at;
        $mission->quantity   = $proposal->quantity ?? 0;
        $mission->unit_price = $proposal->unit_price ?? 0;
        $mission->unit       = $proposal->unit ?? self::UNIT_FIXED_FEES;
        $mission->status     = self::STATUS_READY_TO_START;

        return $mission->save();
    }

    public function getDescriptionHtmlAttribute()
    {
        return strip_tags(nl2br($this->description), '<br>');
    }

    // ------------------------------------------------------------------------
    // Interface methods
    // ------------------------------------------------------------------------

    public function getId(): string
    {
        if (! $this->exists) {
            throw new \RuntimeException("this mission doesn't exists");
        }

        return $this->id;
    }

    public function getStartsAt()
    {
        return $this->starts_at;
    }

    public function getEndsAt()
    {
        return $this->ends_at;
    }

    public function belongsToVendor(EnterpriseEntityInterface $enterprise): bool
    {
        return $this->vendor->id == $enterprise->getId();
    }

    public function getContract(): ?ContractEntityInterface
    {
        return $this->contract()->first();
    }

    public function getWorkField(): ?WorkFieldEntityInterface
    {
        return $this->workField()->first();
    }

    public function getSectorOffer(): ?SectorOffer
    {
        return $this->sectorOffer()->first();
    }

    public function getReferent()
    {
        return $this->referent()->first();
    }
}
