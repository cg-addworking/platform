<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyEmployeEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyEmploye extends Model implements CompanyEmployeEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'company_employees';

    protected $fillable = [
        'short_id',
        'number',
        'range',
        'year',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'number' => 'integer',
        'range' => 'integer',
        'year' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'number' => 0,
        'range' => 0
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    }

    public function getYear()
    {
        return $this->year->format('Y');
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function getRange()
    {
        return $this->range;
    }

    public function getOriginData()
    {
        return $this->origin_data;
    }
}
