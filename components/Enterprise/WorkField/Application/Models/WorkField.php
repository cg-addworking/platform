<?php

namespace Components\Enterprise\WorkField\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Components\Enterprise\WorkField\Application\Models\Scopes\SearchScope;

class WorkField extends Model implements WorkFieldEntityInterface
{
    use HasUuid, SoftDeletes, SearchScope;

    protected $table = "addworking_enterprise_work_fields";

    protected $fillable = [
        'departments', // virtual
        'number',
        'name',
        'display_name',
        'description',
        'estimated_budget',
        'started_at',
        'ended_at',
        'archived_at',
        'external_id',
        'address',
        'project_manager',
        'project_owner', 'sps_coordinator',
    ];

    protected $casts = [
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
        'archived_at' => 'datetime',
        'started_at'  => 'datetime',
        'ended_at'    => 'datetime',
    ];

    protected $with = [
        'workFieldContributors',
    ];
    
    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function owner()
    {
        return $this->belongsTo(Enterprise::class, 'owner_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function workFieldContributors()
    {
        return $this->hasMany(WorkFieldContributor::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }

    public function archivedBy()
    {
        return $this->belongsTo(User::class, 'archived_by')->withDefault();
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'workfield_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'workfield_id');
    }

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'addworking_enterprise_work_field_has_departements',
            'workfield_id',
            'department_id'
        )->withTimestamps();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDisplayName(string $display_name): void
    {
        $this->display_name = $display_name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setEstimatedBudget(?float $estimated_budget): void
    {
        $this->estimated_budget = $estimated_budget;
    }

    public function setStartedAt(?string $started_at): void
    {
        if (! is_null($started_at)) {
            $this->started_at = Carbon::createFromFormat('Y-m-d', $started_at);
        }
    }

    public function setEndedAt(?string $ended_at): void
    {
        if (! is_null($ended_at)) {
            $this->ended_at = Carbon::createFromFormat('Y-m-d', $ended_at);
        }
    }

    public function setExternalId(?string $external_id): void
    {
        $this->external_id = $external_id;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function setProjectManager(?string $project_manager): void
    {
        $this->project_manager = $project_manager;
    }

    public function setProjectOwner(?string $project_owner): void
    {
        $this->project_owner = $project_owner;
    }

    public function unsetDepartments($values): void
    {
        $this->departments()->detach($values);
    }

    public function setDepartments(array $values): void
    {
        $this->departments()->attach($values);
    }

    public function setOwner($enterprise): void
    {
        $this->owner()->associate($enterprise);
    }

    public function setCreatedBy($user): void
    {
        $this->createdBy()->associate($user);
    }

    public function setArchivedAt(): void
    {
        $this->archived_at = Carbon::today();
    }

    public function setArchivedBy($user): void
    {
        $this->archivedBy()->associate($user);
    }

    public function setSpsCoordinator(?string $sps_coordinator): void
    {
        $this->sps_coordinator = $sps_coordinator;
    }

    public function setContracts(array $contracts): void
    {
        $this->contracts()->attach($contracts);
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDescriptionHtml(): ?string
    {
        return strip_tags(nl2br($this->description), '<br>');
    }

    public function getEstimatedBudget(): ?float
    {
        return $this->estimated_budget;
    }

    public function getStartedAt(): ?DateTime
    {
        return $this->started_at;
    }

    public function getEndedAt(): ?DateTime
    {
        return $this->ended_at;
    }

    public function getArchivedAt(): ?DateTime
    {
        return $this->archived_at;
    }

    public function getDepartments()
    {
        return $this->departments()->get();
    }

    public function getOwner(): Enterprise
    {
        return $this->owner()->first();
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy()->get()->first();
    }

    public function getDeletedBy(): User
    {
        return $this->deletedBy()->first();
    }

    public function getArchivedBy(): User
    {
        return $this->archivedBy()->first();
    }

    public function getWorkFieldContributors()
    {
        return $this->workFieldContributors()->get();
    }

    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getProjectManager(): ?string
    {
        return $this->project_manager;
    }

    public function getProjectOwner(): ?string
    {
        return $this->project_owner;
    }

    public function getSpsCoordinator(): ?string
    {
        return $this->sps_coordinator;
    }

    public function getContracts()
    {
        return $this->contracts()->get();
    }
}
