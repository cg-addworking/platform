<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Application\Models\RegistrationOrganization;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyRegistrationOrganizationEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyRegistrationOrganization extends Model implements CompanyRegistrationOrganizationEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'company_registration_organizations';

    protected $fillable = [
        'short_id',
        'registred_at',
        'delisted_at',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'registred_at' => 'date',
        'delisted_at' => 'date',
        'created_at' => "datetime",
        'updated_at' => "datetime",
        'deleted_at' => "datetime",
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    }

    public function organization()
    {
        return $this->belongsTo(RegistrationOrganization::class, 'organization_id')->withDefault();
    }

    public function getOrganization()
    {
        return $this->organization()->first();
    }

    public function getRegisteredAt()
    {
        return $this->registred_at;
    }

    public function getDelistedAt()
    {
        return $this->delisted_at;
    }
}
