<?php

namespace Components\Mission\Mission\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Mission\Application\Models\Scopes\MissionScope;
use Components\Mission\Mission\Domain\Interfaces\Entities\MissionEntityInterface;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Models\Offer as SectorOffer;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mission extends Model implements MissionEntityInterface
{
    use HasUuid,
        MissionScope,
        SoftDeletes;

    protected $table = 'addworking_mission_missions';

    protected $fillable = [
        'number',
        'status',
        'label',
        'description',
        'starts_at',
        'ends_at',
        'external_id',
        'analytic_code',
        'milestone_type',
        'amount'
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
    ];

    protected $attributes = [
        'status' => Mission::STATUS_DRAFT,
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

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
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
        return $this->belongsToMany(File::class, 'addworking_common_files_has_missions')->withTimestamps();
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

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'mission_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'addworking_mission_missions_has_departments')
            ->withTimestamps();
    }

    public function workfield()
    {
        return $this->belongsTo(WorkField::class, 'workfield_id')->withDefault();
    }

    public function referent()
    {
        return $this->belongsTo(User::class, 'referent_id')->withDefault();
    }

    public function proposalResponse()
    {
        return $this->belongsTo(ProposalResponse::class, 'proposal_response_id')->withDefault();
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function costEstimation()
    {
        return $this->belongsTo(CostEstimation::class, 'cost_estimation_id');
    }

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------
    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setLabel($value): void
    {
        $this->label = $value;
    }

    public function setStartsAt($value): void
    {
        $this->starts_at = $value;
    }

    public function setEndsAt($value): void
    {
        $this->ends_at = $value;
    }

    public function setDescription($value): void
    {
        $this->description = $value;
    }

    public function setExternalId($value): void
    {
        $this->external_id = $value;
    }

    public function setAnalyticCode($value): void
    {
        $this->analytic_code = $value;
    }

    public function setCustomer($value): void
    {
        $this->customer()->associate($value);
    }

    public function setVendor($value): void
    {
        $this->vendor()->associate($value);
    }

    public function setReferent($value): void
    {
        $this->referent()->associate($value);
    }

    public function setWorkField($value): void
    {
        $this->workfield()->associate($value);
    }

    public function setSectorOffer(OfferEntityInterface $offer)
    {
        $this->sectorOffer()->associate($offer);
    }

    public function setStatus(string $value): void
    {
        $this->status =  $value;
    }

    public function setDepartments(array $values): void
    {
        $this->departments()->attach($values);
    }

    public function unsetDepartments($values): void
    {
        $this->departments()->detach($values);
    }

    public function setMilestoneType($value): void
    {
        $this->milestone_type = $value;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function setFiles($values): void
    {
        $this->files()->attach($values);
    }

    public function setCostEstimation($value): void
    {
        $this->costEstimation()->associate($value);
    }

    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------
    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getStartsAt()
    {
        return $this->starts_at;
    }

    public function getEndsAt()
    {
        return $this->ends_at;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDescriptionHtml(): ?string
    {
        return strip_tags(nl2br($this->description), '<br>');
    }

    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    public function getAnalyticCode(): ?string
    {
        return $this->analytic_code;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getWorkField()
    {
        return $this->workfield()->first();
    }

    public function getCostEstimation()
    {
        return $this->costEstimation()->first();
    }

    public function getCustomer()
    {
        return $this->customer()->first();
    }

    public function getVendor()
    {
        return $this->vendor()->first();
    }

    public function getContract()
    {
        return $this->contract()->first();
    }

    public function getDepartments()
    {
        return $this->departments()->get();
    }

    public function getSectorOffer(): ?Offer
    {
        return $this->sectorOffer()->first();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getReferent()
    {
        return $this->referent()->first();
    }

    public function getFiles()
    {
        return $this->files()->get();
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getMilestoneType(): ?string
    {
        return $this->milestone_type;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }
}
