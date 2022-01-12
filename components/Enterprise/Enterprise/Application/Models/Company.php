<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\LegalForm;
use Components\Common\Common\Application\Models\Country;
use Components\Enterprise\Enterprise\Application\Models\Scopes\SearchScope;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model implements CompanyEntityInterface
{
    use HasUuid, SoftDeletes, SearchScope;

    protected $table = 'companies';

    protected $fillable = [
        'short_id',
        'identification_number',
        'creation_date',
        'cessation_date',
        'last_updated_at',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'identification_number' => 'string',
        'creation_date' => 'date',
        'cessation_date' => 'date',
        'last_updated_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function legalForm()
    {
        return $this->belongsTo(LegalForm::class, 'legal_form_id')->withDefault();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->withDefault();
    }

    public function invoicingDetails()
    {
        return $this->hasMany(CompanyInvoicingDetail::class);
    }

    public function activities()
    {
        return $this->hasMany(CompanyActivity::class);
    }

    public function establishments()
    {
        return $this->hasMany(CompanyEstablishment::class);
    }

    public function employees()
    {
        return $this->hasMany(CompanyEmploye::class);
    }

    public function legalRepresentatives()
    {
        return $this->hasMany(CompanyLegalRepresentative::class);
    }

    public function denominations()
    {
        return $this->hasMany(CompanyDenomination::class);
    }

    public function registrationOrganizations()
    {
        return $this->hasMany(CompanyRegistrationOrganization::class);
    }

    public function companyShareCapital()
    {
        return $this->hasMany(CompanyShareCapital::class);
    }

    public function getLegalForm()
    {
        return $this->legalForm()->first();
    }

    public function getCountry()
    {
        return $this->country()->first();
    }

    public function getParent()
    {
        return $this->parent()->first();
    }

    public function getInvoicingDetails()
    {
        return $this->invoicingDetails()->get();
    }

    public function getActivities()
    {
        return $this->activities()->get();
    }

    public function getEstablishments()
    {
        return $this->establishments()->get();
    }

    public function getEmployees()
    {
        return $this->employees()->get();
    }

    public function getLegalRepresentatives()
    {
        return $this->legalRepresentatives()->get();
    }

    public function getDenominations()
    {
        return $this->denominations()->get();
    }

    public function getRegistrationOrganizations()
    {
        return $this->registrationOrganizations()->get();
    }

    public function getCompanyShareCapital()
    {
        return $this->companyShareCapital()->get();
    }

    public function getName()
    {
        $denomination = $this->denominations()->latest()->first();
        if ($denomination) {
            $name = $denomination->getName() . " " .$this->getLegalForm()->getDisplayName();
            if (! is_null($denomination->getAcronym())) {
                $name .= " ({$denomination->getAcronym()})";
            }
            return $name;
        }

        return "";
    }

    public function getIdentificationNumber(): string
    {
        return $this->identification_number;
    }

    public function getShortId(): int
    {
        return $this->short_id;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function getCessationDate()
    {
        return $this->cessation_date;
    }

    public function getIsSoleShareholder(): bool
    {
        return $this->is_sole_shareholder;
    }

    public function getLastUpdatedAt()
    {
        return $this->last_updated_at;
    }

    public function getOriginData(): ?string
    {
        return $this->origin_data;
    }
}
