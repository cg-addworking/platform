<?php

namespace Components\Enterprise\WorkField\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldContributorEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkFieldContributor extends Model implements WorkFieldContributorEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_enterprise_work_field_has_contributors";

    protected $fillable = [
        'number',
        'is_admin',
        'is_contract_validator',
        'contract_validation_order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_contract_validator' => 'boolean',
        'contract_validation_order' => 'int',
    ];

    protected $attributes = [
        'is_admin' => false,
        'is_contract_validator' => false,
        'contract_validation_order' => 0,
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function contributor()
    {
        return $this->belongsTo(User::class, 'contributor_id')->withDefault();
    }

    public function workField()
    {
        return $this->belongsTo(WorkField::class, 'work_field_id')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setIsAdmin(bool $is_admin): void
    {
        $this->is_admin = $is_admin;
    }

    public function setIsContractValidator(bool $is_contract_validator): void
    {
        $this->is_contract_validator = $is_contract_validator;
    }

    public function setContractValidationOrder(int $contract_validation_order): void
    {
        $this->contract_validation_order = $contract_validation_order;
    }

    public function setEnterprise($enterprise)
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setContributor($contributor)
    {
        $this->contributor()->associate($contributor);
    }

    public function setWorkField($work_field)
    {
        $this->workField()->associate($work_field);
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getIsAdmin(): bool
    {
        return $this->is_admin;
    }

    public function getIsContractValidator(): bool
    {
        return $this->is_contract_validator;
    }

    public function getContractValidationOrder(): int
    {
        return $this->contract_validation_order;
    }

    public function getContributor()
    {
        return $this->contributor()->first();
    }

    public function getEnterprise()
    {
        return $this->enterprise()->first();
    }

    public function getWorkField()
    {
        return $this->workField()->first();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }
}
