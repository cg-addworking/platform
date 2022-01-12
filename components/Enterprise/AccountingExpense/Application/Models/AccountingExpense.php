<?php

namespace Components\Enterprise\AccountingExpense\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\MissionTrackingLine;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Entities\AccountingExpenseEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountingExpense extends Model implements AccountingExpenseEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_enterprise_accounting_expenses";

    protected $fillable = [
        'number',
        'name',
        'display_name',
        'analytical_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function missionTrackingLines()
    {
        return $this->hasMany(MissionTrackingLine::class, 'accounting_expense_id');
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setEnterprise(Enterprise $enterprise): void
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setName(string $display_name): void
    {
        $this->name = Str::slug($display_name);
    }

    public function setDisplayName(string $display_name): void
    {
        $this->display_name = $display_name;
    }

    public function setAnalyticalCode(?string $analytical_code): void
    {
        $this->analytical_code = $analytical_code;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): string
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getEnterprise(): Enterprise
    {
        return $this->enterprise()->first();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function getAnalyticalCode(): ?string
    {
        return $this->analytical_code;
    }

    public function getMissionTrackingLines()
    {
        return $this->missionTrackingLines()->get();
    }

    // -------------------------------------------------------------------------
    // Filters & Search
    // -------------------------------------------------------------------------
    public function scopeOfEnterprise($query, Enterprise $enterprise)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        });
    }

    public function scopeSearch($query, string $search, string $operator = null, string $field_name = null)
    {
        $search = strtolower($search);

        switch ($operator) {
            case "like":
                return $query->where(DB::raw("LOWER(CAST({$field_name} as TEXT))"), 'LIKE', "%{$search}%");

            case "equal":
                return $query->where(DB::raw("LOWER(CAST({$field_name} as TEXT))"), '=', "$search");

            default:
                return $query->where(DB::raw("LOWER(CAST({$field_name} as TEXT))"), '=', "$search");
        }
    }
}
