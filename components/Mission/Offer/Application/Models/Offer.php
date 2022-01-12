<?php

namespace Components\Mission\Offer\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Application\Models\Scopes\OfferScope;
use Components\Mission\Offer\Application\Models\Scopes\SearchScope;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Offer extends Model implements OfferEntityInterface
{
    use HasUuid, SoftDeletes, OfferScope, SearchScope;

    protected $table = 'addworking_mission_offers';

    protected $fillable = [
        'number',
        'status',
        'label',
        'description',
        'starts_at_desired',
        'ends_at',
        'external_id',
        'analytic_code',
        'response_deadline'
    ];

    protected $casts = [
        'starts_at_desired' => 'date',
        'ends_at' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'response_deadline' => 'date',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function customer()
    {
        return $this->belongsTo(Enterprise::class, 'customer_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function referent()
    {
        return $this->belongsTo(User::class, 'referent_id')->withDefault();
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'addworking_mission_offers_has_departments')
            ->withTimestamps();
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'addworking_mission_offers_has_files')->withTimestamps();
    }

    public function workfield()
    {
        return $this->belongsTo(WorkField::class, 'workfield_id')->withDefault();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'addworking_mission_offers_has_skills')->withTimestamps();
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'mission_offer_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'offer_id');
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

    public function setStartsAtDesired($value): void
    {
        $this->starts_at_desired = $value;
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

    public function setCreatedBy($value): void
    {
        $this->createdBy()->associate($value);
    }

    public function setCustomer($value): void
    {
        $this->customer()->associate($value);
    }

    public function setReferent($value): void
    {
        $this->referent()->associate($value);
    }

    public function setWorkField($value): void
    {
        $this->workfield()->associate($value);
    }

    public function setDepartments(array $values): void
    {
        $this->departments()->attach($values);
    }

    public function setSkills(array $values): void
    {
        $this->skills()->attach($values);
    }

    public function setStatus(string $value): void
    {
        $this->status =  $value;
    }

    public function unsetDepartments($values): void
    {
        $this->departments()->detach($values);
    }

    public function unsetSkills($values): void
    {
        $this->skills()->detach($values);
    }

    public function setResponseDeadline($value): void
    {
        $this->response_deadline = $value;
    }
    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------
    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getStartsAtDesired()
    {
        return $this->starts_at_desired;
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

    public function getCustomer()
    {
        return $this->customer()->first();
    }

    public function getDepartments()
    {
        return $this->departments()->get();
    }

    public function getSkills()
    {
        return $this->skills()->get();
    }

    public function getProposals()
    {
        return $this->proposals()->get();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getReferent()
    {
        return $this->referent()->first();
    }

    public function getResponses()
    {
        return $this->responses()->get();
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

    public function getResponseDeadline()
    {
        return $this->response_deadline;
    }
}
