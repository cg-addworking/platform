<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use Components\Common\Common\Application\Models\Country;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\RegistrationOrganizationEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationOrganization extends Model implements RegistrationOrganizationEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'registration_organizations';

    protected $fillable = [
        'short_id',
        'name',
        'acronym',
        'location',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'name' => 'string',
        'acronym' => 'string',
        'location' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------
   
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    public function getCountry()
    {
        return $this->country()->first();
    }

    public function getName(): string
    {
        return ucfirst($this->name);
    }

    public function getAcronym(): string
    {
        return strtoupper($this->acronym);
    }

    public function getLocation(): ?string
    {
        return strtoupper($this->location);
    }

    public function getCode()
    {
        return $this->code;
    }
}
