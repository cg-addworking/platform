<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyDenominationEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyDenomination extends Model implements CompanyDenominationEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'company_denominations';

    protected $fillable = [
        'short_id',
        'name',
        'commercial_name',
        'acronym',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'name' => 'string',
        'commercial_name' => 'string',
        'acronym' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCommercialName(): ?string
    {
        return $this->commercial_name;
    }

    public function getAcronym(): ?string
    {
        return $this->acronym;
    }
}
