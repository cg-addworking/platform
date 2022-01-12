<?php

namespace Components\Enterprise\BusinessTurnover\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Entities\BusinessTurnoverEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessTurnover extends Model implements BusinessTurnoverEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_enterprise_business_turnovers";

    protected $fillable = [
        'number',
        'amount',
        'year',
        'no_activity',
        'enterprise_name',
        'created_by_name'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'no_activity' => false,
        'amount' => 0
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function setEnterprise(Enterprise $enterprise): void
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setEnterpriseName(string $name): void
    {
        $this->enterprise_name = $name;
    }

    public function setCreatedBy(User $user): void
    {
        $this->createdBy()->associate($user);
    }

    public function setCreatedByName(string $name): void
    {
        $this->created_by_name = $name;
    }

    public function setNoActivity(bool $no_activity): void
    {
        $this->no_activity = $no_activity;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getEnterprise(): Enterprise
    {
        return $this->enterprise()->first();
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy()->first();
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getNoActivity(): bool
    {
        return $this->no_activity;
    }

    public function getCreatedByName(): string
    {
        return $this->created_by_name;
    }
}
